<?php

namespace App\Livewire;

use App\Helpers\DNS;
use App\Helpers\Page;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Search extends Component
{
    #[Locked]
    public $limit;          // Rate-limit? (true|false)

    #[Locked]
    public $data;           // Data array

    public $text;           // User search text

    // Validation rules
    protected $rules = [
        'text' => [
            'bail',         // Stop after the first validation error
            'required',     // Mandatory
            'min:4',        // Min length: 4
            'max:255',      // Max length: 255
            'regex:'        // Domain regex (split for legibility)
                . '/^(?!\-)'
                . '(?:(?:[a-zA-Z\d][a-zA-Z\d\-]{0,61})?[a-zA-Z\d]\.){1,126}'
                . '(?!\d+)[a-zA-Z\d]{1,63}$/',
        ]
    ];

    /* Search a domain; Results are cached for 5 minutes */
    #[Computed(persist: true, seconds: 60 * 5)]
    private function get_records($domain)
    {
        $this->data['dnssec'] = DNS::checkDNSSEC($domain);
        $this->data['records'] = DNS::getRecords($domain);
    }

    /* Handle form search */
    public function search()
    {
        // Validate data
        $validated = $this->validate();

        // Check if we have validated data
        if (isset($validated['text'])) {
            // Get records
            $this->get_records($validated['text']);
        }
    }

    /* Validate property on update */
    public function updated($property)
    {
        $this->validateOnly($property);
    }

    /* Rate-limit requests */
    private function ratelimit()
    {
        /* Assign a unique key */
        $key = 'livewire:'.auth()->id();

        /* Check if we've hit the rate limit */
        $limit = RateLimiter::tooManyAttempts($key, 10);

        /* Increment ratelimit attempts */
        RateLimiter::hit($key);

        return $limit;
    }

    public function render()
    {
        /* If we hit a ratelimit, tell that to the
           frontend, and clear the results list */
        if ($this->ratelimit()) {
            $this->limit = true;
            $this->data = [];
        }

        /* Minified view */
        return Page::minify('livewire.search', [
            'limit' => $this->limit,
            'data' => $this->data,
        ]);
    }
}
