<?php
namespace App\Controllers\Api\V2;

class Company extends Api
{
    use Traits\CrudElementTrait;

    protected $IBlockId = 3;
    //Поля необходимые для проверки
    protected $fieldsNeedCheck = [
        'create' => ['name', 'code', 'xmlCode'],
        'update' => ['id']
    ];
    protected $prepareTextFields = ['ID' => 'id', 'NAME' => 'name', 'CODE' => 'code', 'ACTIVE' => 'active', 'XML_ID' => 'xmlCode', 'SORT' => 'sort', 'IBLOCK_SECTION_ID' => 'iBlockSectionId', 'PREVIEW_TEXT' => 'previewText', 'DETAIL_TEXT' => 'detailText'];
    protected $prepareDateFields = ['DATE_ACTIVE_FROM' => 'dateActiveFrom', 'DATE_ACTIVE_TO' => 'dateActiveTo'];
    protected $prepareFileFields = ['PREVIEW_PICTURE' => 'previewPicture', 'DETAIL_PICTURE' => 'detailPicture'];
    protected $prepareTextProperties = ['FOOT_FROM_METRO' => 'footFromMetro', 'ADDRESS' => 'address', 'EMAIL' => 'email', 'STATUS' => 'status', 'COMPANY' => 'company',];
    protected $prepareDirProperties = ['METRO' => 'metro',];
    protected $prepareFileProperties = ['LOGO' => 'logo', 'GALLERY' => 'gallery'];
    protected $preparePointProperties = ['MAP_POINT' => 'mapPoint'];
}