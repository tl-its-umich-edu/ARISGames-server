<?php
require_once("module.php");
require_once("../../libraries/wideimage/WideImage.php");

class Media extends Module
{
    const MEDIA_IMAGE = 'Image';
    const MEDIA_ICON = 'Icon';
    const MEDIA_VIDEO = 'Video';
    const MEDIA_AUDIO = 'Audio';
    protected $validImageAndIconTypes = array('jpg','png','gif');
    protected $validAudioTypes = array('mp3','m4a','caf');
    protected $validVideoTypes = array('mp4','m4v','3gp','mov');

    public function parseRawMedia($media)
    {
        $media->file_name = $media->file_path; //this is for legacy reasons... Phil 10/12/2012
        $media->thumb_file_path = substr($media->file_path,0,strrpos($media->file_path,'.')).'_128'.substr($media->file_path,strrpos($media->file_path,'.'));
        $media->url_path = Config::gamedataWWWPath . "/";
        $media->url       = $media->url_path."/".$media->file_path;
        $media->thumb_url = $media->url_path."/".$media->thumb_file_path;

        if($media->is_icon == '1') $media->type = self::MEDIA_ICON;
        else $media->type = Media::getMediaType($media->file_path);

        if($media->game_id == 0) $media->is_default = 1;
        else $media->is_default = 0;

        return $media;
    }

    public function getMedia($gameId)
    {
        $medias = Module::query("SELECT * FROM media WHERE (game_id = '{$gameId}' OR game_id = 0) AND SUBSTRING(file_path,1,1) != 'p'");

        $data = array();
        while($media = mysql_fetch_object($medias))
            $data[] = Media::parseRawMedia($media);
        return new returnData(0, $data);
    }

    public function getMediaObject($gameId, $mediaId)
    {
        //apparently, "is_numeric(NAN)" returns 'true'. NAN literally means "Not A Number". Think about that one for a sec.
        if(!$mediaId || !is_numeric($mediaId) || $mediaId == NAN //return new returnData(2, NULL, "No matching media");
        || !($media = Module::queryObject("SELECT * FROM media WHERE media_id = {$mediaId} LIMIT 1")))
	{
		$media = new stdClass;
                $media->game_id = 0;
        	$media->media_id = $mediaId;
        	$media->name = "Default NPC";
        	$media->file_path = "0/npc.png";
        	return new returnData(0, Media::parseRawMedia($media));
	}

        return new returnData(0, Media::parseRawMedia($media));
    }	

    public function getValidAudioExtensions()
    {
        return new returnData(0, $this->validAudioTypes);
    }

    public function getValidVideoExtensions()
    {
        return new returnData(0, $this->validVideoTypes);
    }

    public function getValidImageAndIconExtensions()
    {
        return new returnData(0, $this->validImageAndIconTypes);
    }

    public function createMedia($gameId, $strName, $strFileName, $boolIsIcon)
    {
        if($gameId == "player")
        {
            $gameId = 0;
            $strFileName = "player/".$strFileName;
        }
        else
        {
            $strFileName = $gameId."/".$strFileName;
        }

        $strName = addslashes($strName);

        if ($boolIsIcon && $this->getMediaType($strFileName) != self::MEDIA_IMAGE)
            return new returnData(4, NULL, "Icons must have a valid Image file extension");

        $query = "INSERT INTO media 
            (game_id, name, file_path, is_icon)
            VALUES ('{$gameId}','{$strName}', '".$strFileName."',{$boolIsIcon})";

        Module::query($query);
        if (mysql_error()) return new returnData(3, NULL, "SQL Error:".mysql_error());

        $media = new stdClass();
        $media->media_id = mysql_insert_id();
        $media->game_id = $gameId;
        $media->name = $strName;
        $media->file_path = $strFileName;

        return new returnData(0,Media::parseRawMedia($media));
    }

    public function renameMedia($gameId, $mediaId, $strName, $editorId, $editorToken)
    {
        if(!Module::authenticateGameEditor($gameId, $editorId, $editorToken, "read_write"))
            return new returnData(6, NULL, "Failed Authentication");

        if($gameId == 'player') $gameId = '';

        $strName = addslashes($strName);

        //Update this record
        $query = "UPDATE media 
            SET name = '{$strName}' 
            WHERE media_id = '{$mediaId}' and game_id = '{$gameId}'";

        Module::query($query);
        if (mysql_error()) return new returnData(3, NULL, "SQL Error");

        if (mysql_affected_rows()) return new returnData(0, TRUE);
        else return new returnData(0, FALSE);	
    }

    public function deleteMedia($gameId, $mediaId, $editorId, $editorToken)
    {
        if(!Module::authenticateGameEditor($gameId, $editorId, $editorToken, "read_write"))
            return new returnData(6, NULL, "Failed Authentication");

        $query = "SELECT * FROM media 
            WHERE media_id = {$mediaId}";
        $rsResult = Module::query($query);
        if (mysql_error()) return new returnData(3, NULL, "SQL Error:". mysql_error());

        $mediaRow = mysql_fetch_array($rsResult);
        if($mediaRow === FALSE) return new returnData(2, NULL, "Invalid Media Record");

        //Delete the Record
        $query = "DELETE FROM media 
            WHERE media_id = {$mediaId}";

        $rsResult = Module::query($query);
        if (mysql_error()) return new returnData(3, NULL, "SQL Error:" . mysql_error());

        //Delete the file		
        $fileToDelete = Config::gamedataFSPath . "/" . $mediaRow['file_path'];
        if (!@unlink($fileToDelete)) 
            return new returnData(4, NULL, "Record Deleted but file was not: $fileToDelete");

        //Done
        if (mysql_affected_rows()) return new returnData(0, TRUE);
        else return new returnData(0, FALSE);	
    }	

    public function getMediaDirectory($gameId)
    {
        return new returnData(0, Config::gamedataFSPath . "/{$gameId}");
    }

    public function getMediaDirectoryURL($gameId)
    {
        return new returnData(0, Config::gamedataWWWPath . "/{$gameId}");
    }	

    public function getMediaType($strMediaFileName)
    {
        $mediaParts = pathinfo($strMediaFileName);
        $mediaExtension = $mediaParts['extension'];

        $validImageAndIconTypes = array('jpg','png','gif');
        $validAudioTypes = array('mp3','m4a','caf');
        $validVideoTypes = array('mp4','m4v','3gp','mov');

        if (in_array($mediaExtension, $validImageAndIconTypes )) return Media::MEDIA_IMAGE;
        else if (in_array($mediaExtension, $validAudioTypes )) return Media::MEDIA_AUDIO;
        else if (in_array($mediaExtension, $validVideoTypes )) return Media::MEDIA_VIDEO;

        return '';
    }	

    public function createMediaFromJSON($glob)
    {
        $path     = $glob->path;
        $filename = $glob->filename;
        $data     = $glob->data;
        $resizeTo = isset($glob->resizeTo) ? $glob->resizeTo : null;
        
        $gameMediaDirectory = Media::getMediaDirectory($path)->data;

        $md5 = md5((string)microtime().$filename);
        $ext = strtolower(substr($filename, -3));
        $newMediaFileName = 'aris'.$md5.'.'.$ext;
        $resizedMediaFileName = 'aris'.$md5.'_128.'.$ext;

        if(
                //Images
                $ext != "jpg" &&
                $ext != "png" &&
                $ext != "gif" &&
                //Video
                $ext != "mp4" &&
                $ext != "mov" &&
                $ext != "m4v" &&
                $ext != "3gp" &&
                //Audio
                $ext != "caf" &&
                $ext != "mp3" &&
                $ext != "aac" &&
                $ext != "m4a" &&
                //Overlays
                $ext != "zip" //oh god bad
          )
        return new returnData(1,NULL,"Invalid filetype:$ext");

        $fullFilePath = $gameMediaDirectory."/".$newMediaFileName;

        if (isset($resizeTo) && ($ext == "jpg" || $ext == "png" || $ext == "gif"))
        {
            $bigFilePath = $gameMediaDirectory."/big_".$newMediaFileName;
            $fp = fopen($bigFilePath, 'w');
            if(!$fp) return new returnData(1,NULL,"Couldn't open file:$bigFilePath");
            fwrite($fp,base64_decode($data));
            fclose($fp);
            $image = new Imagick($bigFilePath);

            // Reorient based on EXIF tag
            switch ($image->getImageOrientation()) {
                case Imagick::ORIENTATION_UNDEFINED:
                    // We assume normal orientation
                    break;
                case Imagick::ORIENTATION_TOPLEFT:
                    // All good
                    break;
                case Imagick::ORIENTATION_TOPRIGHT:
                    $image->flopImage();
                    break;
                case Imagick::ORIENTATION_BOTTOMRIGHT:
                    $image->rotateImage('#000', 180);
                    break;
                case Imagick::ORIENTATION_BOTTOMLEFT:
                    $image->rotateImage('#000', 180);
                    $image->flopImage();
                    break;
                case Imagick::ORIENTATION_LEFTTOP:
                    $image->rotateImage('#000', 90);
                    $image->flopImage();
                    break;
                case Imagick::ORIENTATION_RIGHTTOP:
                    $image->rotateImage('#000', 90);
                    break;
                case Imagick::ORIENTATION_RIGHTBOTTOM:
                    $image->rotateImage('#000', -90);
                    $image->flopImage();
                    break;
                case Imagick::ORIENTATION_LEFTBOTTOM:
                    $image->rotateImage('#000', -90);
                    break;
            }
            $image->setImageOrientation(Imagick::ORIENTATION_TOPLEFT);

            // Resize image proportionally so min(width, height) == $resizeTo
            if ($image->getImageWidth() < $image->getImageHeight()) {
              $image->resizeImage($resizeTo, 0, Imagick::FILTER_LANCZOS, 1);
            }
            else {
              $image->resizeImage(0, $resizeTo, Imagick::FILTER_LANCZOS, 1);
            }

            $image->setImageCompression(Imagick::COMPRESSION_JPEG);
            $image->setImageCompressionQuality(40);
            $image->writeImage($fullFilePath);
            unlink($bigFilePath);
        }
        else
        {
            $fp = fopen($fullFilePath, 'w');
            if(!$fp) return new returnData(1,NULL,"Couldn't open file:$fullFilePath");
            fwrite($fp,base64_decode($data));
            fclose($fp);
        }

        if($ext == "jpg" || $ext == "png" || $ext == "gif")
        {
            $img = WideImage::load($fullFilePath);
            $img = $img->resize(128, 128, 'outside');
            $img = $img->crop('center','center',128,128);
            $img->saveToFile($gameMediaDirectory."/".$resizedMediaFileName);
        }
        else if($ext == "mp4") //only works with mp4
        {
            /*
               $ffmpeg = '../../libraries/ffmpeg';
               $videoFilePath      = $gameMediaDirectory."/".$newMediaFileName; 
               $tempImageFilePath  = $gameMediaDirectory."/temp_".$resizedMediaFileName; 
               $imageFilePath      = $gameMediaDirectory."/".$resizedMediaFileName; 
               $cmd = "$ffmpeg -i $videoFilePath 2>&1"; 
               $thumbTime = 1;
               if(preg_match('/Duration: ((\d+):(\d+):(\d+))/s', shell_exec($cmd), $videoLength))
               $thumbTime = (($videoLength[2] * 3600) + ($videoLength[3] * 60) + $videoLength[4])/2; 
               $cmd = "$ffmpeg -i $videoFilePath -deinterlace -an -ss $thumbTime -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $tempImageFilePath 2>&1"; 
               shell_exec($cmd);

               $img = WideImage::load($tempImageFilePath);
               $img = $img->resize(128, 128, 'outside');
               $img = $img->crop('center','center',128,128);
               $img->saveToFile($imageFilePath);
             */
        }

        $m = Media::createMedia($path, "UploadedMedia", $newMediaFileName, 0);
        return new returnData(0,$m->data);
    }
}
?>
