<?php
 namespace Purnamasari\JD\Request;

class SellerProductApiWriteOnShelfRequest
{
	private $apiParas = array();
	
	public function getApiMethodName(){
	  return "jingdong.seller.product.api.write.onShelf";
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
                                                             	                        	                                                                                                                                                                                                                                                                                                               private $spuId;
                              public function setSpuId($spuId ){
                 $this->spuId=$spuId;
                 $this->apiParas["spuId"] = $spuId;
              }

              public function getSpuId(){
              	return $this->spuId;
              }
                                                                                                                                        	}





        
 

