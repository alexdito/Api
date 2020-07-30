<?php
namespace App\Controllers\Api\V2;

class Service extends Api
{
    use Traits\CrudElementTrait;

    protected $IBlockId = 1;

    //Поля необходимые для проверки
    protected $fieldsNeedCheck = [
        'create' => ['name', 'code', 'xmlCode', 'companyId'],
        'update' => ['id']
    ];
    protected $prepareTextFields = ['ID' => 'id', 'NAME' => 'name', 'CODE' => 'code', 'ACTIVE' => 'active', 'XML_ID' => 'xmlCode', 'SORT' => 'sort', 'IBLOCK_SECTION' => 'iBlockSectionId', 'PREVIEW_TEXT' => 'previewText', 'DETAIL_TEXT' => 'detailText'];
    protected $prepareFileFields = ['PREVIEW_PICTURE' => 'previewPicture', 'DETAIL_PICTURE' => 'detailPicture'];
    protected $prepareDateFields = ['DATE_ACTIVE_FROM' => 'dateActiveFrom', 'DATE_ACTIVE_TO' => 'dateActiveTo'];

    protected $prepareTextProperties = ['DURATION' => 'duration', 'ADDRESS' => 'address', 'VERIFICATION_LINK' => 'verificationLink', 'STATUS' => 'status'];
    protected $prepareDirProperties = ['LESSONS' => 'lessons', 'METRO' => 'metro'];
    protected $prepareListProperties = ['TYPE' => 'type'];
    protected $prepareFileProperties = ['GALLERY' => 'gallery'];
    protected $preparePointProperties = ['MAP_POINT' => 'mapPoint'];
    protected $prepareAgeProperties =['AGE' =>'age', 'AGE_TO' => 'ageTo'];
    protected $prepareBindProperties = ['COMPANY_ID' => 'companyId'];
    protected $prepareCustomCheckbox = ['POPULAR' => 'popular'];
    protected $prepareIntProperties = ['SALE' => 'sale', 'FOOT_FROM_METRO' => 'footFromMetro', 'CHILD_COUNT_FROM' => 'childrenCountFrom', 'CHILD_COUNT_TO' => 'childrenCountTo', 'OLD_PRICE' => 'oldPrice', 'MIN_PRICE' => 'minPrice', 'RATING' => 'rating', 'COUNT_REVIEW' => 'countReview'];
    protected $prepareDateProperties = ['START_DATE' => 'startDate', 'END_DATE' => 'endDate'];
    protected $prepareAccessInstruction = ['ACCESS_INSTRUCTION' => 'accessInstruction'];
}