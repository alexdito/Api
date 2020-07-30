<?php
namespace App\Controllers\Api\V2;


class BranchOffice extends Api
{
    use Traits\CrudSectionTrait;

    protected $IBlockId = 3;
    //Поля требующие обязательной проверки
    protected $fieldsNeedCheck = [
        'create' =>['name', 'code'],
        'update' =>['id']
    ];

    protected $prepareTextFields = ['ID' => 'id', 'NAME' => 'name', 'CODE' => 'code', 'IBLOCK_SECTION_ID' => 'iBlockSectionId', 'ACTIVE' => 'active', 'PICTURE' => 'picture', 'DESCRIPTION' => 'description', 'XML_ID' => 'xmlCode'];
    protected $prepareFileFields = ['PICTURE' => 'picture'];
}