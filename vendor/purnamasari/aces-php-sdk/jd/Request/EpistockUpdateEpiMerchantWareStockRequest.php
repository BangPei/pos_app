<?php
 namespace Purnamasari\JD\Request;

class EpistockUpdateEpiMerchantWareStockRequest
{
	private $apiParas = array();
	
	public function getApiMethodName(){
	  return "jingdong.epistock.updateEpiMerchantWareStock";
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
                                    	                   			private $wareStockUpdateListStr;
    	                        
	public function setWareStockUpdateListStr($wareStockUpdateListStr){
		$this->wareStockUpdateListStr = $wareStockUpdateListStr;
         $this->apiParas["wareStockUpdateListStr"] = $wareStockUpdateListStr;
	}

	public function getWareStockUpdateListStr(){
	  return $this->wareStockUpdateListStr;
	}

                        	}





        
 

