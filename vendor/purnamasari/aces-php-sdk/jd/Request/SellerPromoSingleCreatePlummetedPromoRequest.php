<?php
 namespace Purnamasari\JD\Request;

class SellerPromoSingleCreatePlummetedPromoRequest
{
	private $apiParas = array();
	
	public function getApiMethodName(){
	  return "jingdong.seller.promo.singleCreatePlummetedPromo";
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
                                                        		                                    	                   			private $riskLevel;
    	                        
	public function setRiskLevel($riskLevel){
		$this->riskLevel = $riskLevel;
         $this->apiParas["riskLevel"] = $riskLevel;
	}

	public function getRiskLevel(){
	  return $this->riskLevel;
	}

                        	                   			private $promoChannel;
    	                        
	public function setPromoChannel($promoChannel){
		$this->promoChannel = $promoChannel;
         $this->apiParas["promoChannel"] = $promoChannel;
	}

	public function getPromoChannel(){
	  return $this->promoChannel;
	}

                        	                        	                   			private $bindToken;
    	                        
	public function setBindToken($bindToken){
		$this->bindToken = $bindToken;
         $this->apiParas["bindToken"] = $bindToken;
	}

	public function getBindToken(){
	  return $this->bindToken;
	}

                        	                   			private $promoNum;
    	                        
	public function setPromoNum($promoNum){
		$this->promoNum = $promoNum;
         $this->apiParas["promoNum"] = $promoNum;
	}

	public function getPromoNum(){
	  return $this->promoNum;
	}

                        	                        	                   			private $limitBuyType;
    	                        
	public function setLimitBuyType($limitBuyType){
		$this->limitBuyType = $limitBuyType;
         $this->apiParas["limitBuyType"] = $limitBuyType;
	}

	public function getLimitBuyType(){
	  return $this->limitBuyType;
	}

                        	                   			private $quota;
    	                        
	public function setQuota($quota){
		$this->quota = $quota;
         $this->apiParas["quota"] = $quota;
	}

	public function getQuota(){
	  return $this->quota;
	}

                        	                        	                   			private $promoAdword;
    	                        
	public function setPromoAdword($promoAdword){
		$this->promoAdword = $promoAdword;
         $this->apiParas["promoAdword"] = $promoAdword;
	}

	public function getPromoAdword(){
	  return $this->promoAdword;
	}

                        	                        	                   			private $beginTime;
    	                        
	public function setBeginTime($beginTime){
		$this->beginTime = $beginTime;
         $this->apiParas["beginTime"] = $beginTime;
	}

	public function getBeginTime(){
	  return $this->beginTime;
	}

                                                 	                        	                                                                                                                                                                                                                                                                                        private $areaId;
                              public function setAreaId($areaId ){
                 $this->areaId=$areaId;
                 $this->apiParas["areaId"] = $areaId;
              }

              public function getAreaId(){
              	return $this->areaId;
              }
                                                                                                                                                                                                                                                                                                                       private $pId;
                              public function setPId($pId ){
                 $this->pId=$pId;
                 $this->apiParas["pId"] = $pId;
              }

              public function getPId(){
              	return $this->pId;
              }
                                                                                                                                                                                                                                                                                                                       private $areaTag;
                              public function setAreaTag($areaTag ){
                 $this->areaTag=$areaTag;
                 $this->apiParas["areaTag"] = $areaTag;
              }

              public function getAreaTag(){
              	return $this->areaTag;
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

                        	                   			private $promoType;
    	                        
	public function setPromoType($promoType){
		$this->promoType = $promoType;
         $this->apiParas["promoType"] = $promoType;
	}

	public function getPromoType(){
	  return $this->promoType;
	}

                        	                   			private $promoName;
    	                        
	public function setPromoName($promoName){
		$this->promoName = $promoName;
         $this->apiParas["promoName"] = $promoName;
	}

	public function getPromoName(){
	  return $this->promoName;
	}

                        	                   			private $activityUrl;
    	                        
	public function setActivityUrl($activityUrl){
		$this->activityUrl = $activityUrl;
         $this->apiParas["activityUrl"] = $activityUrl;
	}

	public function getActivityUrl(){
	  return $this->activityUrl;
	}

                        	                   			private $limitBuyMaxNum;
    	                        
	public function setLimitBuyMaxNum($limitBuyMaxNum){
		$this->limitBuyMaxNum = $limitBuyMaxNum;
         $this->apiParas["limitBuyMaxNum"] = $limitBuyMaxNum;
	}

	public function getLimitBuyMaxNum(){
	  return $this->limitBuyMaxNum;
	}

                        	                   			private $limitBuyMinNum;
    	                        
	public function setLimitBuyMinNum($limitBuyMinNum){
		$this->limitBuyMinNum = $limitBuyMinNum;
         $this->apiParas["limitBuyMinNum"] = $limitBuyMinNum;
	}

	public function getLimitBuyMinNum(){
	  return $this->limitBuyMinNum;
	}

                        	                   			private $endTime;
    	                        
	public function setEndTime($endTime){
		$this->endTime = $endTime;
         $this->apiParas["endTime"] = $endTime;
	}

	public function getEndTime(){
	  return $this->endTime;
	}

                        	                   			private $mobileActivityUrl;
    	                        
	public function setMobileActivityUrl($mobileActivityUrl){
		$this->mobileActivityUrl = $mobileActivityUrl;
         $this->apiParas["mobileActivityUrl"] = $mobileActivityUrl;
	}

	public function getMobileActivityUrl(){
	  return $this->mobileActivityUrl;
	}

                        	                   			private $promoReason;
    	                        
	public function setPromoReason($promoReason){
		$this->promoReason = $promoReason;
         $this->apiParas["promoReason"] = $promoReason;
	}

	public function getPromoReason(){
	  return $this->promoReason;
	}

                        	                   			private $storeId;
    	                        
	public function setStoreId($storeId){
		$this->storeId = $storeId;
         $this->apiParas["storeId"] = $storeId;
	}

	public function getStoreId(){
	  return $this->storeId;
	}

                            }





        
 

