<?php

namespace DaydreamLab\Media\Services\File\Front;

use Carbon\Carbon;
use DaydreamLab\Cms\Models\Brand\Brand;
use DaydreamLab\JJAJ\Exceptions\ForbiddenException;
use DaydreamLab\JJAJ\Exceptions\InternalServerErrorException;
use DaydreamLab\JJAJ\Exceptions\NotFoundException;
use DaydreamLab\Media\Repositories\File\Front\FileFrontRepository;
use DaydreamLab\Media\Repositories\FileCategory\FileCategoryRepository;
use DaydreamLab\Media\Services\File\FileService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class FileFrontService extends FileService
{
    protected $fileCategoryRepository;

    public function __construct(FileFrontRepository $repo, FileCategoryRepository $fileCategoryRepository)
    {
        parent::__construct($repo);
        $this->repo = $repo;
        $this->fileCategoryRepository = $fileCategoryRepository;
    }


    public function download(Collection $input)
    {
        $item = $this->findBy('uuid', '=', $input->get('uuid'))->first();
        if (!$item) {
            throw new NotFoundException('ItemNotExist', ['uuid' =>  $input->get('uuid')], null, $this->modelName);
        }
/*
        if ($item->password) {
            if(!Hash::check($input->get('password'), $item->password)) {
                throw new ForbiddenException('PasswordIncorrect');
            }
        }
*/

        $this->response = $item;

        if ($this->getProvider() == 'azure') {
            $client = $this->getAzureClient();
            try {
                $blob = $client->getBlob($this->azureContainer, $item->blobName);
            } catch (\Throwable $t) {
                if ($t->getCode() == 404) {
                    throw new NotFoundException('BlobNotFound', 404);
                } else {
                    throw new InternalServerErrorException('BlobError', 500);
                }
            }

            return $blob;
        }
    }


    public function search(Collection $input, $paginate = true)
    {
        if ( $contentType = $input->get('contentType') ) {
            $q = $input->get('q');
            $fcs = $this->fileCategoryRepository->getByContentTypeAndExtension($contentType);
            $fcIds = $fcs->pluck(['id']);
            $q = $q->whereIn('category_id', $fcIds);
            $input->put('q', $q);
        }
        $input->forget('contentType');

        if ( $categoryAlias = $input->get('categoryAlias') ) {
            $category = $this->fileCategoryRepository->findBy('alias', '=', $categoryAlias)->first();
            if ($category) {
                $q = $input->get('q');
                $q = $q->where('category_id', $category->id);
                $input->put('q', $q);
            }
        }
        $input->forget('categoryAlias');

        if ( $brand_alias = $input->get('brand_alias') ) {
            $brand = Brand::where('alias', $brand_alias)->first();

            if ($brand) {
                $q = $input->get('q');
                $q = $q->whereHas('brands', function ($query) use ($brand) {
                    $query->where('brands_files_maps.brand_id', $brand->id);
                });
                $input->put('q', $q);
            }
        }
        $input->forget('brand_alias');

        if ( $search_date = $input->get('search_date') ) {
            $split = explode('/', $search_date, 2);
            $year = (int)$split[0];
            $month = (int)$split[1];
            $search_date_start = Carbon::createFromDate($year, $month)->startOfMonth();
            $search_date_end = Carbon::createFromDate($year, $month)->endOfMonth();
            $q = $input->get('q');
            $q = $q->where('created_at', '>=', $search_date_start)->where('created_at', '<=', $search_date_end);
            $input->put('q', $q);
        }
        $input->forget('search_date');

        $input->put('paginate', $paginate);
        $input->put('state', 1);
        return parent::search($input);
    }
}
