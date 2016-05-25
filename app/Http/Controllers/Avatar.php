<?php namespace App\Http\Controllers;

use App\Date;
use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Component\HttpFoundation\File\File;


class Avatar
{
  private $translit;
  private $inputFile;
  private $fileName;
  private $dirPath;
  private $thumbPath;
  private $file;
  private $img;

  private $imgUrl;
  private $thumbUrl;


  public function __construct()
  {
    $this->dirPath = public_path('images');
    $this->thumbPath = public_path('images/thumb');
    $this->imgUrl = url('/images').'/';
    $this->thumbUrl = url('/images/thumb').'/';
  }

  public function input($file)
  {
    $this->inputFile = $file;
    $this->file = new File($file);
    return $this;
  }

  public function fileName($fileName = '')
  {
    $this->fileName = $fileName.'.'.$this->file->guessExtension();
    return $this;
  }

  public function move($dirName, $resize = array())
  {
    $this->dirPath .= '/'.$dirName;
    $this->thumbPath .= '/'.$dirName;

    $this->file->move($this->dirPath, $this->fileName);

    if(count($resize) > 0)
      $this->resize(
        $resize['w'],
        $resize['h']
      );

    return $this;
  }

  public function resize($w, $h, $aspectRatio = true)
  {
    $img = $this->dirPath.'/'.$this->fileName;
    $this->resizeProcess($w,$h,$aspectRatio,$img);

    $thumb = $this->thumbPath.'/'.$this->fileName;

    if (!copy($img, $thumb)) {
      echo "не удалось скопировать $img...\n";
    }

    $this->resizeProcess(50,null,true,$img,$thumb);

  }


  private function resizeProcess($w, $h, $aspectRatio = true, $imgPath, $savePath = null)
  {
    if($savePath == null)
      $savePath = $imgPath;

    // create instance
    $img = Image::make($imgPath);

    // resize only the width of the image
    if($w != null && $h == null && $aspectRatio == false)
      $img->resize($w, null);

    // resize only the height of the image
    if($w == null && $h != null && $aspectRatio == false)
      $img->resize(null, $h);

    // resize the image to a width of 300 and constrain aspect ratio (auto height)
    if($w != null && $h == null && $aspectRatio == true)
      $img->resize($w, null, function ($constraint) {
        $constraint->aspectRatio();
      });

    if($w == null && $h != null && $aspectRatio == true)
      $img->resize(null, $h, function ($constraint) {
        $constraint->aspectRatio();
      });

    // add callback functionality to retain maximal original image size
    if($w != null && $h != null && $aspectRatio == false)
      $img->fit($w, $h);

    // prevent possible upsizing
    /*
    $img->resize(null, 400, function ($constraint) {
      $constraint->aspectRatio();
      $constraint->upsize();
    });
    */

    $img->save($savePath);
  }

  public function getFileName()
  {
    return $this->fileName;
  }

  public function getThumb($dirName,$img)
  {
    return '<img src="'.$this->thumbUrl.$dirName.'/'.$img.'">';
  }

  public function getImg($dirName,$img)
  {
    if($dirName)
      $imgPath = $this->imgUrl.$dirName;
    else
      $imgPath = $this->imgUrl;

    return '<img src="'.$imgPath.'/'.$img.'"/>';
  }

  public function delete($dirName,$fileName)
  {
    $imgPath = $this->dirPath.'/'.$dirName.'/'.$fileName;
    $thumbPath = $this->thumbPath.'/'.$dirName.'/'.$fileName;
    unlink($imgPath);
    unlink($thumbPath);
  }

}