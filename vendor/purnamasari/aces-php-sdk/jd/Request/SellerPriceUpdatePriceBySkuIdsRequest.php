<?php
 namespace Purnamasari\JD\Request;

class SellerPriceUpdatePriceBySkuIdsRequest
{
	private $apiParas = array();
	
	public function getApiMethodName(){
	  return "jingdong.seller.price.updatePriceBySkuIds";
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
                                                             	                        	                                                                                                                                                                                                                                                                                                               private $salePrice;
                              public function setSalePrice($salePrice ){
                 $this->salePrice=$salePrice;
                 $this->apiParas["salePrice"] = $salePrice;
              }

              public function getSalePrice(){
              	return $this->salePrice;
              }
                                                                                                                                                                                                                                                                                                                                              private $skuId;
                              public function setSkuId($skuId ){
                 $this->skuId=$skuId;
                 $this->apiParas["skuId"] = $skuId;
              }

              public function getSkuId(){
              	return $this->skuId;
              }
                                                                                                                                        	}





        
 

