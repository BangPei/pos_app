<?php
 namespace Purnamasari\JD\Request;

class SellerProductApiWriteUpdateProductRequest
{
	private $apiParas = array();
	
	public function getApiMethodName(){
	  return "jingdong.seller.product.api.write.updateProduct";
	}
	
	public function getApiParas(){
	    if(empty($this->apiParas)){
            return "{}";
        }
        return json_encode($this->apiParas);
	}
	
	public function check(){
		
	}
	
	public function putOtherTextParam($key, $value){
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}

    private  $version;

    public function setVersion($version){
        $this->version = $version;
    }

    public function getVersion(){
        return $this->version;
    }
                                                        		                                    	                   			private $packLong;
    	                        
	public function setPackLong($packLong){
		$this->packLong = $packLong;
         $this->apiParas["packLong"] = $packLong;
	}

	public function getPackLong(){
	  return $this->packLong;
	}

                        	                   			private $spuName;
    	                        
	public function setSpuName($spuName){
		$this->spuName = $spuName;
         $this->apiParas["spuName"] = $spuName;
	}

	public function getSpuName(){
	  return $this->spuName;
	}

                        	                   			private $commonAttributeIds;
    	                        
	public function setCommonAttributeIds($commonAttributeIds){
		$this->commonAttributeIds = $commonAttributeIds;
         $this->apiParas["commonAttributeIds"] = $commonAttributeIds;
	}

	public function getCommonAttributeIds(){
	  return $this->commonAttributeIds;
	}

                        	                   			private $keywords;
    	                        
	public function setKeywords($keywords){
		$this->keywords = $keywords;
         $this->apiParas["keywords"] = $keywords;
	}

	public function getKeywords(){
	  return $this->keywords;
	}

                        	                   			private $description;
    	                        
	public function setDescription($description){
		$this->description = $description;
         $this->apiParas["description"] = $description;
	}

	public function getDescription(){
	  return $this->description;
	}

                        	                   			private $countryId;
    	                        
	public function setCountryId($countryId){
		$this->countryId = $countryId;
         $this->apiParas["countryId"] = $countryId;
	}

	public function getCountryId(){
	  return $this->countryId;
	}

                        	                   			private $warrantyPeriod;
    	                        
	public function setWarrantyPeriod($warrantyPeriod){
		$this->warrantyPeriod = $warrantyPeriod;
         $this->apiParas["warrantyPeriod"] = $warrantyPeriod;
	}

	public function getWarrantyPeriod(){
	  return $this->warrantyPeriod;
	}

                        	                   			private $productArea;
    	                        
	public function setProductArea($productArea){
		$this->productArea = $productArea;
         $this->apiParas["productArea"] = $productArea;
	}

	public function getProductArea(){
	  return $this->productArea;
	}

                        	                   			private $minQuantity;
    	                        
	public function setMinQuantity($minQuantity){
		$this->minQuantity = $minQuantity;
         $this->apiParas["minQuantity"] = $minQuantity;
	}

	public function getMinQuantity(){
	  return $this->minQuantity;
	}

                        	                   			private $crossProductType;
    	                        
	public function setCrossProductType($crossProductType){
		$this->crossProductType = $crossProductType;
         $this->apiParas["crossProductType"] = $crossProductType;
	}

	public function getCrossProductType(){
	  return $this->crossProductType;
	}

                        	                   			private $packHeight;
    	                        
	public function setPackHeight($packHeight){
		$this->packHeight = $packHeight;
         $this->apiParas["packHeight"] = $packHeight;
	}

	public function getPackHeight(){
	  return $this->packHeight;
	}

                        	                   			private $taxesType;
    	                        
	public function setTaxesType($taxesType){
		$this->taxesType = $taxesType;
         $this->apiParas["taxesType"] = $taxesType;
	}

	public function getTaxesType(){
	  return $this->taxesType;
	}

                        	                   			private $appDescription;
    	                        
	public function setAppDescription($appDescription){
		$this->appDescription = $appDescription;
         $this->apiParas["appDescription"] = $appDescription;
	}

	public function getAppDescription(){
	  return $this->appDescription;
	}

                        	                   			private $weight;
    	                        
	public function setWeight($weight){
		$this->weight = $weight;
         $this->apiParas["weight"] = $weight;
	}

	public function getWeight(){
	  return $this->weight;
	}

                        	                   			private $subtitleHrefM;
    	                        
	public function setSubtitleHrefM($subtitleHrefM){
		$this->subtitleHrefM = $subtitleHrefM;
         $this->apiParas["subtitleHrefM"] = $subtitleHrefM;
	}

	public function getSubtitleHrefM(){
	  return $this->subtitleHrefM;
	}

                        	                   			private $qualityDays;
    	                        
	public function setQualityDays($qualityDays){
		$this->qualityDays = $qualityDays;
         $this->apiParas["qualityDays"] = $qualityDays;
	}

	public function getQualityDays(){
	  return $this->qualityDays;
	}

                        	                   			private $packWide;
    	                        
	public function setPackWide($packWide){
		$this->packWide = $packWide;
         $this->apiParas["packWide"] = $packWide;
	}

	public function getPackWide(){
	  return $this->packWide;
	}

                        	                   			private $catId;
    	                        
	public function setCatId($catId){
		$this->catId = $catId;
         $this->apiParas["catId"] = $catId;
	}

	public function getCatId(){
	  return $this->catId;
	}

                        	                   			private $whetherCod;
    	                        
	public function setWhetherCod($whetherCod){
		$this->whetherCod = $whetherCod;
         $this->apiParas["whetherCod"] = $whetherCod;
	}

	public function getWhetherCod(){
	  return $this->whetherCod;
	}

                        	                   			private $piece;
    	                        
	public function setPiece($piece){
		$this->piece = $piece;
         $this->apiParas["piece"] = $piece;
	}

	public function getPiece(){
	  return $this->piece;
	}

                        	                   			private $brandId;
    	                        
	public function setBrandId($brandId){
		$this->brandId = $brandId;
         $this->apiParas["brandId"] = $brandId;
	}

	public function getBrandId(){
	  return $this->brandId;
	}

                        	                   			private $subtitle;
    	                        
	public function setSubtitle($subtitle){
		$this->subtitle = $subtitle;
         $this->apiParas["subtitle"] = $subtitle;
	}

	public function getSubtitle(){
	  return $this->subtitle;
	}

                        	                   			private $isQuality;
    	                        
	public function setIsQuality($isQuality){
		$this->isQuality = $isQuality;
         $this->apiParas["isQuality"] = $isQuality;
	}

	public function getIsQuality(){
	  return $this->isQuality;
	}

                        	                   			private $spuId;
    	                        
	public function setSpuId($spuId){
		$this->spuId = $spuId;
         $this->apiParas["spuId"] = $spuId;
	}

	public function getSpuId(){
	  return $this->spuId;
	}

                        	                   			private $packageInfo;
    	                        
	public function setPackageInfo($packageInfo){
		$this->packageInfo = $packageInfo;
         $this->apiParas["packageInfo"] = $packageInfo;
	}

	public function getPackageInfo(){
	  return $this->packageInfo;
	}

                        	                   			private $afterSale;
    	                        
	public function setAfterSale($afterSale){
		$this->afterSale = $afterSale;
         $this->apiParas["afterSale"] = $afterSale;
	}

	public function getAfterSale(){
	  return $this->afterSale;
	}

                        	                   			private $clearanceType;
    	                        
	public function setClearanceType($clearanceType){
		$this->clearanceType = $clearanceType;
         $this->apiParas["clearanceType"] = $clearanceType;
	}

	public function getClearanceType(){
	  return $this->clearanceType;
	}

                        	                   			private $subtitleHref;
    	                        
	public function setSubtitleHref($subtitleHref){
		$this->subtitleHref = $subtitleHref;
         $this->apiParas["subtitleHref"] = $subtitleHref;
	}

	public function getSubtitleHref(){
	  return $this->subtitleHref;
	}

                        	                   			private $maxQuantity;
    	                        
	public function setMaxQuantity($maxQuantity){
		$this->maxQuantity = $maxQuantity;
         $this->apiParas["maxQuantity"] = $maxQuantity;
	}

	public function getMaxQuantity(){
	  return $this->maxQuantity;
	}

                                                 	                        	                                                                                                                                                                                                                                                                                                               private $shopCategoryIds;
                              public function setShopCategoryIds($shopCategoryIds ){
                 $this->shopCategoryIds=$shopCategoryIds;
                 $this->apiParas["shopCategoryIds"] = $shopCategoryIds;
              }

              public function getShopCategoryIds(){
              	return $this->shopCategoryIds;
              }
                                                                                                                                                                    	}





        
 

