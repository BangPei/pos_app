<?php
 namespace Purnamasari\JD\Request;

class SellerPromoQueryPlummetedInfoByConditionRequest
{
	private $apiParas = array();
	
	public function getApiMethodName(){
	  return "jingdong.seller.promo.queryPlummetedInfoByCondition";
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
                                                        		                                    	                   			private $thirdArea;
    	                        
	public function setThirdArea($thirdArea){
		$this->thirdArea = $thirdArea;
         $this->apiParas["thirdArea"] = $thirdArea;
	}

	public function getThirdArea(){
	  return $this->thirdArea;
	}

                        	                   			private $pageSize;
    	                        
	public function setPageSize($pageSize){
		$this->pageSize = $pageSize;
         $this->apiParas["pageSize"] = $pageSize;
	}

	public function getPageSize(){
	  return $this->pageSize;
	}

                        	                   			private $ltCreateTime;
    	                        
	public function setLtCreateTime($ltCreateTime){
		$this->ltCreateTime = $ltCreateTime;
         $this->apiParas["ltCreateTime"] = $ltCreateTime;
	}

	public function getLtCreateTime(){
	  return $this->ltCreateTime;
	}

                        	                   			private $secondArea;
    	                        
	public function setSecondArea($secondArea){
		$this->secondArea = $secondArea;
         $this->apiParas["secondArea"] = $secondArea;
	}

	public function getSecondArea(){
	  return $this->secondArea;
	}

                        	                   			private $promoId;
    	                        
	public function setPromoId($promoId){
		$this->promoId = $promoId;
         $this->apiParas["promoId"] = $promoId;
	}

	public function getPromoId(){
	  return $this->promoId;
	}

                        	                        	                   			private $skuId;
    	                        
	public function setSkuId($skuId){
		$this->skuId = $skuId;
         $this->apiParas["skuId"] = $skuId;
	}

	public function getSkuId(){
	  return $this->skuId;
	}

                        	                   			private $childType;
    	                        
	public function setChildType($childType){
		$this->childType = $childType;
         $this->apiParas["childType"] = $childType;
	}

	public function getChildType(){
	  return $this->childType;
	}

                        	                   			private $userGrade;
    	                        
	public function setUserGrade($userGrade){
		$this->userGrade = $userGrade;
         $this->apiParas["userGrade"] = $userGrade;
	}

	public function getUserGrade(){
	  return $this->userGrade;
	}

                        	                        	                   			private $ltBeginTime;
    	                        
	public function setLtBeginTime($ltBeginTime){
		$this->ltBeginTime = $ltBeginTime;
         $this->apiParas["ltBeginTime"] = $ltBeginTime;
	}

	public function getLtBeginTime(){
	  return $this->ltBeginTime;
	}

                        	                   			private $promoState;
    	                        
	public function setPromoState($promoState){
		$this->promoState = $promoState;
         $this->apiParas["promoState"] = $promoState;
	}

	public function getPromoState(){
	  return $this->promoState;
	}

                        	                   			private $firstArea;
    	                        
	public function setFirstArea($firstArea){
		$this->firstArea = $firstArea;
         $this->apiParas["firstArea"] = $firstArea;
	}

	public function getFirstArea(){
	  return $this->firstArea;
	}

                        	                   			private $page;
    	                        
	public function setPage($page){
		$this->page = $page;
         $this->apiParas["page"] = $page;
	}

	public function getPage(){
	  return $this->page;
	}

                        	                   			private $gtCreateTime;
    	                        
	public function setGtCreateTime($gtCreateTime){
		$this->gtCreateTime = $gtCreateTime;
         $this->apiParas["gtCreateTime"] = $gtCreateTime;
	}

	public function getGtCreateTime(){
	  return $this->gtCreateTime;
	}

                        	                   			private $riskLevel;
    	                        
	public function setRiskLevel($riskLevel){
		$this->riskLevel = $riskLevel;
         $this->apiParas["riskLevel"] = $riskLevel;
	}

	public function getRiskLevel(){
	  return $this->riskLevel;
	}

                        	                   			private $gtBeginTime;
    	                        
	public function setGtBeginTime($gtBeginTime){
		$this->gtBeginTime = $gtBeginTime;
         $this->apiParas["gtBeginTime"] = $gtBeginTime;
	}

	public function getGtBeginTime(){
	  return $this->gtBeginTime;
	}

                        	                   			private $gtEndTime;
    	                        
	public function setGtEndTime($gtEndTime){
		$this->gtEndTime = $gtEndTime;
         $this->apiParas["gtEndTime"] = $gtEndTime;
	}

	public function getGtEndTime(){
	  return $this->gtEndTime;
	}

                        	                   			private $promoName;
    	                        
	public function setPromoName($promoName){
		$this->promoName = $promoName;
         $this->apiParas["promoName"] = $promoName;
	}

	public function getPromoName(){
	  return $this->promoName;
	}

                        	                   			private $ltEndTime;
    	                        
	public function setLtEndTime($ltEndTime){
		$this->ltEndTime = $ltEndTime;
         $this->apiParas["ltEndTime"] = $ltEndTime;
	}

	public function getLtEndTime(){
	  return $this->ltEndTime;
	}

                        	                   			private $spuId;
    	                        
	public function setSpuId($spuId){
		$this->spuId = $spuId;
         $this->apiParas["spuId"] = $spuId;
	}

	public function getSpuId(){
	  return $this->spuId;
	}

                        	                   	                    		private $storeIds;
    	                        
	public function setStoreIds($storeIds){
		$this->storeIds = $storeIds;
         $this->apiParas["storeIds"] = $storeIds;
	}

	public function getStoreIds(){
	  return $this->storeIds;
	}

                            }





        
 

