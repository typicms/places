<?php

declare(strict_types=1);

namespace TypiCMS\Modules\Places\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Exports\EscapesFormulas;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Places\Models\Place;

/**
 * @implements WithMapping<mixed>
 */
class Export implements FromCollection, ShouldAutoSize, WithColumnFormatting, WithHeadings, WithMapping, WithStrictNullComparison
{
    use EscapesFormulas;

    /** @return Collection<int, Place> */
    public function collection(): Collection
    {
        return QueryBuilder::for(Place::class)
            ->allowedSorts('id', 'status_translated', 'title_translated')
            ->allowedFilters(
                AllowedFilter::custom('title', new FilterOr),
            )
            ->get();
    }

    /** @return array<int, mixed> */
    public function map(mixed $row): array
    {
        return [
            Date::dateTimeToExcel($row->created_at),
            Date::dateTimeToExcel($row->updated_at),
            $row->status,
            $this->escapeFormula($row->address),
            $this->escapeFormula($row->email),
            $this->escapeFormula($row->website),
            $this->escapeFormula($row->phone),
            $row->latitude,
            $row->longitude,
            $this->escapeFormula($row->title),
            $this->escapeFormula($row->summary),
            $this->escapeFormula($row->body),
        ];
    }

    /** @return string[] */
    public function headings(): array
    {
        return [
            __('Created at'),
            __('Updated at'),
            __('Published'),
            __('Address'),
            __('Email'),
            __('Website'),
            __('Phone'),
            __('Latitude'),
            __('Longitude'),
            __('Title'),
            __('Summary'),
            __('Body'),
        ];
    }

    /** @return array<string, string> */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DATETIME,
            'B' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }
}
