<?php

namespace App;

use App\Sdc\Utilities\CustomLog;
use Illuminate\Database\Eloquent\Model;
use JD\Cloudder\Facades\Cloudder;
use Exception;

class Ad extends Model
{
    private $class;

    public function __construct()
    {
        $this->class = "Ad";
    }

    public function campaign()
    {
        return $this->belongsTo('App\Campaign');
    }

    public function uploadImage(array $request, $image_type)
    {
        $metodo = "uploadImage";

        $result = array();

        try {
            $file = \Illuminate\Http\UploadedFile::createFromBase($request[$image_type]);
            $result['name'] = $file->getClientOriginalName();
            $image = $file->getRealPath();
            Cloudder::upload($image, null);
            list($width, $height) = getimagesize($image);
            $result['public_id'] = Cloudder::getPublicId();
            $result['url'] = Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
            CustomLog::debug($this->class, $metodo, "Se cargo imagen: " . $result['name'] . " a Cloudinary.");
        } catch (Exception $ex) {
            CustomLog::debug($this->class, $metodo, "Error al procesar imagen");
            return null;
        }

        return $result;
    }
}
