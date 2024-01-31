<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class ProcessedXmlFiles extends Model
{

    public $table = 'processed_xml_files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
       
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */

    public function checkDuplicateFile($fileName)
    {
        $date = date('Y-m-d');
        return ProcessedXmlFiles::whereDate('created_at', 'LIKE', $date.'%')->where('file_name','=',$fileName)->count();
    }

    public static function splittedDuplicateFilesCount()
    {
        $date = date('Y-m-d');
        return ProcessedXmlFiles::whereDate('created_at', 'LIKE', $date.'%')
            ->groupBy('file_name')
            ->havingRaw('count(file_name) > ?', [1])
            ->pluck('id');
    }

    public static function splittedFilesCount()
    {
        $date = date('Y-m-d');
        return ProcessedXmlFiles::whereDate('created_at', 'LIKE', $date.'%')->groupBy('file_name')->get()->count();
    }

    public static function splittedProcessFilesCount()
    {
        $date = date('Y-m-d');
        return ProcessedXmlFiles::whereDate('created_at', 'LIKE', $date.'%')->where('is_completed', 0)->groupBy('file_name')->get()->count();
    }

    public static function splittedCompleteFilesCount()
    {
        $date = date('Y-m-d');
        return ProcessedXmlFiles::whereDate('created_at', 'LIKE', $date.'%')->where('is_completed', 1)->groupBy('file_name')->get()->count();
    }

    public static function showDeleteButtonQuery()
    {
        $date = date('Y-m-d');
        return ProcessedXmlFiles::whereDate('created_at', 'LIKE', $date.'%')
            ->where('is_completed', 0)
            ->groupBy('is_completed')
            ->get()
            ->count();
    }
}
