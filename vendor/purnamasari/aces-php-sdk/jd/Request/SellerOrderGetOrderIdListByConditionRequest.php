<?php
 namespace Purnamasari\JD\Request;

class SellerOrderGetOrderIdListByConditionRequest
{
	private $apiParas = array();
	
	public function getApiMethodName(){
	  return "jingdong.seller.order.getOrderIdListByCondition";
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
                                    	                        	                                            		                                    	                   			private $bookTimeEnd;
    	                        
	public function setBookTimeEnd($bookTimeEnd){
		$this->bookTimeEnd = $bookTimeEnd;
         $this->apiParas["bookTimeEnd"] = $bookTimeEnd;
	}

	public function getBookTimeEnd(){
	  return $this->bookTimeEnd;
	}

                        	                   			private $userPin;
    	                        
	public function setUserPin($userPin){
		$this->userPin = $userPin;
         $this->apiParas["userPin"] = $userPin;
	}

	public function getUserPin(){
	  return $this->userPin;
	}

                        	                   			private $orderType;
    	                        
	public function setOrderType($orderType){
		$this->orderType = $orderType;
         $this->apiParas["orderType"] = $orderType;
	}

	public function getOrderType(){
	  return $this->orderType;
	}

                        	                   			private $updateTimeEnd;
    	                        
	public function setUpdateTimeEnd($updateTimeEnd){
		$this->updateTimeEnd = $updateTimeEnd;
         $this->apiParas["updateTimeEnd"] = $updateTimeEnd;
	}

	public function getUpdateTimeEnd(){
	  return $this->updateTimeEnd;
	}

                        	                   			private $startRow;
    	                        
	public function setStartRow($startRow){
		$this->startRow = $startRow;
         $this->apiParas["startRow"] = $startRow;
	}

	public function getStartRow(){
	  return $this->startRow;
	}

                        	                   			private $deliveryType;
    	                        
	public function setDeliveryType($deliveryType){
		$this->deliveryType = $deliveryType;
         $this->apiParas["deliveryType"] = $deliveryType;
	}

	public function getDeliveryType(){
	  return $this->deliveryType;
	}

                        	                   			private $orderStatus;
    	                        
	public function setOrderStatus($orderStatus){
		$this->orderStatus = $orderStatus;
         $this->apiParas["orderStatus"] = $orderStatus;
	}

	public function getOrderStatus(){
	  return $this->orderStatus;
	}

                        	                   			private $createdTimeEnd;
    	                        
	public function setCreatedTimeEnd($createdTimeEnd){
		$this->createdTimeEnd = $createdTimeEnd;
         $this->apiParas["createdTimeEnd"] = $createdTimeEnd;
	}

	public function getCreatedTimeEnd(){
	  return $this->createdTimeEnd;
	}

                        	                   			private $updateTimeBegin;
    	                        
	public function setUpdateTimeBegin($updateTimeBegin){
		$this->updateTimeBegin = $updateTimeBegin;
         $this->apiParas["updateTimeBegin"] = $updateTimeBegin;
	}

	public function getUpdateTimeBegin(){
	  return $this->updateTimeBegin;
	}

                        	                   			private $createdTimeBegin;
    	                        
	public function setCreatedTimeBegin($createdTimeBegin){
		$this->createdTimeBegin = $createdTimeBegin;
         $this->apiParas["createdTimeBegin"] = $createdTimeBegin;
	}

	public function getCreatedTimeBegin(){
	  return $this->createdTimeBegin;
	}

                        	                   			private $bookTimeBegin;
    	                        
	public function setBookTimeBegin($bookTimeBegin){
		$this->bookTimeBegin = $bookTimeBegin;
         $this->apiParas["bookTimeBegin"] = $bookTimeBegin;
	}

	public function getBookTimeBegin(){
	  return $this->bookTimeBegin;
	}

                        	                   			private $pageNo;
    	                        
	public function setPageNo($pageNo){
		$this->pageNo = $pageNo;
         $this->apiParas["pageNo"] = $pageNo;
	}

	public function getPageNo(){
	  return $this->pageNo;
	}

                        	                   			private $pageSize;
    	                        
	public function setPageSize($pageSize){
		$this->pageSize = $pageSize;
         $this->apiParas["pageSize"] = $pageSize;
	}

	public function getPageSize(){
	  return $this->pageSize;
	}

                        	                   	                    		private $siteIdListQuery;
    	                        
	public function setSiteIdListQuery($siteIdListQuery){
		$this->siteIdListQuery = $siteIdListQuery;
         $this->apiParas["siteIdListQuery"] = $siteIdListQuery;
	}

	public function getSiteIdListQuery(){
	  return $this->siteIdListQuery;
	}

                            }





        
 

