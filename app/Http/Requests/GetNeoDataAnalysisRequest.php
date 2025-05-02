<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class GetNeoDataAnalysisRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'start_date' => ['nullable', 'date', 'before_or_equal:end_date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ];
    }

    public function hasDateRange () : bool
    {
        return $this->filled('start_date') && $this->filled('end_date');
    }

    public function startDate(): ?Carbon
    {
        return $this->filled('start_date') ? Carbon::parse($this->input('start_date'))->startOfDay() : null;
    }

    public function endDate(): ?Carbon
    {
        return $this->filled('end_date') ? Carbon::parse($this->input('end_date'))->endOfDay() : null;
    }
}
