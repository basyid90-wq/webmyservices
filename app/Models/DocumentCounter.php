<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DocumentCounter extends Model
{
    protected $fillable = [
        'doc_type',
        'y',
        'm',
        'last_seq',
    ];

    public static function generateDocNo(string $docType): string
    {
        $prefixes = [
            'QUOTE' => 'QUOTE',
            'INVOICE' => 'INVOICE',
            'RECEIPT' => 'RECEIPT',
        ];

        $prefix = $prefixes[$docType] ?? $docType;
        $y = (int) date('Y');
        $m = (int) date('m');

        $counter = DB::transaction(function () use ($docType, $y, $m) {
            $row = self::where('doc_type', $docType)
                ->where('y', $y)
                ->where('m', $m)
                ->lockForUpdate()
                ->first();

            if (!$row) {
                $row = self::create([
                    'doc_type' => $docType,
                    'y' => $y,
                    'm' => $m,
                    'last_seq' => 0,
                ]);
            }

            $row->increment('last_seq');

            return $row->fresh();
        });

        return sprintf('%s-%d%02d-%03d', $prefix, $y, $m, $counter->last_seq);
    }
}
