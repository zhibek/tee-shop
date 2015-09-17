<?php


$entityTypeId = Mage::getModel('catalog/product')
        ->getResource()
        ->getEntityType()
        ->getId(); //product entity type

$attributeSetName='Set-t-shirt';

$attributeSet = Mage::getModel('eav/entity_attribute_set')
        ->setEntityTypeId($entityTypeId)
        ->setAttributeSetName("$attributeSetName");

$attributeSet->validate();
$attributeSet->save();

$attributeSet->initFromSkeleton(2)->save(); // id of set

$modelGroup = Mage::getModel('eav/entity_attribute_group');
//set the group name
$modelGroup->setAttributeGroupName('t-shirt') //change group name
        //link to the current set
        ->setAttributeSetId($attributeSet->getId())
        //set the order in the set
        // it will be used to set attributes init
        ->setSortOrder(1);
//save the new group
$modelGroup->save();
// attribute set id 
$attributeSetId = $this->getAttributeSetId($entityTypeId, $attributeSetName);
// 1 is the attribute order
$this->addAttributeToSet($entityTypeId, $attributeSetId, 't-shirt', 'primary-colour', 1);
$this->addAttributeToSet($entityTypeId, $attributeSetId, 't-shirt', 'size', 1);


