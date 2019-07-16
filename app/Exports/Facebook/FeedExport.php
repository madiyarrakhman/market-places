<?php
/**
 * Created by PhpStorm.
 * User: madiyarrakhman
 * Date: 6/13/19
 * Time: 4:45 PM
 */

namespace App\Exports\Facebook;


use App\Models\Facebook\Feed;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class FeedExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function collection()
    {
        return Feed::all();
    }

    /**
     * @return Builder
     */
    public function query()
    {
        return Feed::query()->where('is_active', '!=',0)->whereNotNull('image_link');
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->ps_id,
            $row->title,
            $row->brand,
            $row->description,
            $row->image_link,
            $row->link,
            $row->price.' KZT',
            ($row->quantity <= 0) ? '0' : $row->quantity,
            'new',
            'in stock'
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'title',
            'brand',
            'description',
            'image_link',
            'link',
            'price',
            'inventory',
            'condition',
            'availability'
        ];
    }
}