<?php

namespace App\Utils;

use Illuminate\Support\Facades\Storage;

/**
 * The CommonUtils class
 */
class CommonUtils
{

    /// properties

    /// const

    # define default array with pagination info
    const PAGINATION_INFO = [
        'page' => 1,
        'per_page' => 10,
        'total_pages' => 0,
        'total_records' => 0,
    ];
    # define const with records per page
    const RECORDS_PER_PAGE = [5, 10, 20, 35, 50, 100];
    # define const with text size reference
    const TEXT_SIZE = [
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'md' => 'text-md',
        'lg' => 'text-lg',
        'xl' => 'text-xl',
        '2xl' => 'text-2xl',
    ];

    /// public functions

    /// private functions

    /// static functions

    /**
     * valid if a value is number
     * @param $value => value to check
     * @return bool => true if the value is number, false if not
     */
    public static function isNumber($value) : bool
    {
        return (bool) preg_match("/^[0-9]+$/", $value);
    }

    /**
     * get offset value from pagination data using page and records per page
     *
     * @param array $pagination
     * @return integer
     */
    public static function getOffset(array $pagination) : int
    {
        return ($pagination['page'] - 1) * $pagination['per_page'];
    }

    /**
     * generate a file name with unique key and tag, optional a date
     * @param string $key
     * @param string $tag
     * @param $date
     * @return string
     */
    public static function generateUniqueFileName(string $key, string $tag, $date = null) : string
    {
        return mb_strtolower($key, 'UTF-8') . "_" . mb_strtolower($tag, 'UTF-8') . ($date != null ? str_replace([' ', '-', '/'], '_', $date) : null);
    }

    /**
     * delete a file
     * @param $filePath => the file path to deleted
     * @return array =>
     * 'state' => -1 for no action was taken, 0 for could not delete the file, 1 for file deleted successfully and 2 for file not found.
     * 'message' array => with 'es' and 'en' messages
     */
    public static function deleteFileFromAppStorage($filePath) : array
    {
        # define default response
        $response = [
            'state' => -1,
            'message' => [
                'es' => 'No se realizó ninguna acción.',
                'en' => 'No action was taken.',
            ],
        ];

        # if file exist
        if (Storage::fileExists($filePath))
        {
            # use try
            try {
                # delete file
                Storage::delete($filePath);
                # set response as success
                $response['state'] = 1;
                $response['message']['es'] = 'Archivo eliminado exitosamente.';
                $response['message']['en'] = 'File deleted successfully.';
            }
            catch (\Exception $e)
            {
                # put error message in log
                error_log($e->getMessage());
                # set response as failed
                $response['state'] = 0;
                $response['message']['es'] = 'No fue posible eliminar el archivo.';
                $response['message']['en'] = 'Could not delete the file.';
            }
        }
        # else, file not exist
        else
        {
            # set response as info
            $response['state'] = 2;
            $response['message']['es'] = 'Archivo no encontrado.';
            $response['message']['en'] = 'File not found.';
        }

        return $response;
    }

    /**
     * get url of image
     * @param $filePath => file path
     * @return string => url of img
     */
    public static function getImage($filePath): string
    {
        # define default image url
        $imgUrl = Storage::url(__DIR__ . '/../../public/img/no_image.png');

        # if exist file
        if ($filePath)
        {
            if (Storage::exists($filePath))
                $imgUrl = Storage::url($filePath);
        }

        return $imgUrl;
    }

    /**
     * get value of key in array
     * @param string|int $key => needle
     * @param array $array => the array to get value
     * @return string|int|bool|array|null => value
     */
    public static function getKeyValueFromArray(string|int $key, array $array) : string|int|bool|array|null
    {
        # define default value
        $value = null;
        # if key exist in array
        if (array_key_exists($key, $array))
            $value = $array[$key];
        # return value
        return $value;
    }

    /**
     * set each first letter of each word in uppercase
     * @param string $str
     * @param string $encoding
     * @return string
     */
    public static function ucwordsCustom(string $str, string $encoding = 'UTF-8') : string
    {
        return ucwords(mb_strtolower($str, $encoding));
    }

}
