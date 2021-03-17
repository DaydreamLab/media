<?php

namespace DaydreamLab\Media\Services\Media;

use DaydreamLab\JJAJ\Helpers\Helper;
use DaydreamLab\Media\Repositories\Media\MediaRepository;
use DaydreamLab\JJAJ\Services\BaseService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;
use DaydreamLab\JJAJ\Helpers\ResponseHelper;

class MediaService extends BaseService
{
    protected $type = 'Media';

    protected $media_storage = null;

    protected $thumb_storage = null;

    protected $media_storage_type = 'media-public';

    protected $thumb_storage_type = 'media-thumb';

    protected $media_path = null;

    protected $media_link_base = '/storage/media';

    protected $thumb_path = null;

    protected $userMerchantID = null;

    public function __construct(MediaRepository $repo)
    {
        if( config('media.dddream-merchant-mode') ){
            $this->media_storage_type = 'media-public-merchant';
            $this->thumb_storage_type = 'media-thumb-merchant';
            $this->media_link_base .= '/merchant';

            $userMerchant = Auth::guard('api')->user()->merchants->first();
            if( $userMerchant ){
                $this->userMerchantID = $userMerchant->id;
            }else{
                throw new HttpResponseException(
                    ResponseHelper::genResponse(
                        Str::upper(Str::snake('MediaThisAdminUserNotHaveMerchant'))
                    )
                );
            }
        }

        $this->media_storage = Storage::disk($this->media_storage_type);
        $this->thumb_storage = Storage::disk($this->thumb_storage_type);
        $this->media_path    = $this->media_storage->getDriver()->getAdapter()->getPathPrefix();
        $this->thumb_path    = $this->thumb_storage->getDriver()->getAdapter()->getPathPrefix();

        if( config('media.dddream-merchant-mode') ){
            //Helper::show(Auth::guard('api')->user()->merchants->first()->id);
            if( !$this->media_storage->exists($this->userMerchantID) &&
                !$this->thumb_storage->exists($this->userMerchantID) ){
                //利用merchantID建構Dir
                $result_media   = $this->media_storage->makeDirectory($this->userMerchantID, intval( '0755', 8 ));
                $result_thumb   = $this->thumb_storage->makeDirectory($this->userMerchantID, intval( '0755', 8 ));
            }
            $this->media_path    = $this->media_storage->getDriver()->getAdapter()->getPathPrefix().$this->userMerchantID.'/';
            $this->thumb_path    = $this->thumb_storage->getDriver()->getAdapter()->getPathPrefix().$this->userMerchantID.'/';
        }
        parent::__construct($repo);
    }


    public function exist(Collection $input)
    {
        return $this->media_storage->exists($input->dir . '/' . $input->name) &&
            $this->thumb_storage->exists($input->dir . '/' . $input->name) ?: false;
    }


    public function deleteStorage($old, $new)
    {
        return $this->media_storage->move($old, $new) &&
        $this->thumb_storage->move($old, $new) ?: false;
    }



    public function moveStorage($old, $new)
    {
        return $this->media_storage->move($old, $new) &&
                $this->thumb_storage->move($old, $new) ?: false;
    }

}
