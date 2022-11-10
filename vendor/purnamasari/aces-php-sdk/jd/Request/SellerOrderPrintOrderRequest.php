<?php
 namespace Purnamasari\JD\Request;

class SellerOrderPrintOrderRequest
{
	private $apiParas = array();
	
	public function getApiMethodName(){
	  return "jingdong.seller.order.printOrder";
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
                                                        		                                    	                   			private $printType;
    	                        
	public function setPrintType($printType){
		$this->printType = $printType;
         $this->apiParas["printType"] = $printType;
	}

	public function getPrintType(){
	  return $this->printType;
	}

                        	                   			private $printNum;
    	                        
	public function setPrintNum($printNum){
		$this->printNum = $printNum;
         $this->apiParas["printNum"] = $printNum;
	}

	public function getPrintNum(){
	  return $this->printNum;
	}

                        	                        	                   			private $orderId;
    	                        
	public function setOrderId($orderId){
		$this->orderId = $orderId;
         $this->apiParas["orderId"] = $orderId;
	}

	public function getOrderId(){
	  return $this->orderId;
	}

                        	                            }





        
 

