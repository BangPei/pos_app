<?php
 namespace Purnamasari\JD\Request;

class SellerPromoSingleTerminatePromoRequest
{
	private $apiParas = array();
	
	public function getApiMethodName(){
	  return "jingdong.seller.promo.singleTerminatePromo";
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
                                                        		                                    	                   			private $processId;
    	                        
	public function setProcessId($processId){
		$this->processId = $processId;
         $this->apiParas["processId"] = $processId;
	}

	public function getProcessId(){
	  return $this->processId;
	}

                        	                   			private $promoId;
    	                        
	public function setPromoId($promoId){
		$this->promoId = $promoId;
         $this->apiParas["promoId"] = $promoId;
	}

	public function getPromoId(){
	  return $this->promoId;
	}

                        	                        	                        	                            }





        
 

