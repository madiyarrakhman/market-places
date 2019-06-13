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

class FeedExport implements FromQuery, WithMapping, WithHeadings
{
    public function collection()
    {
        return Feed::all();
    }

    /**
     * @return Builder
     */
    public function query()
    {
        return Feed::query();
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
            $row->description,
            $row->image_link,
            $row->link,
            $row->price,
            'new',
            'in stock'
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'title',
            'description',
            'image_link',
            'link',
            'price',
            'condition',
            'availability'
        ];
    }
}