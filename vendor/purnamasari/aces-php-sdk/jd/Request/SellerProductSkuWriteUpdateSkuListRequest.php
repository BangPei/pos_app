<?php
 namespace Purnamasari\JD\Request;

class SellerProductSkuWriteUpdateSkuListRequest
{
	private $apiParas = array();
	
	public function getApiMethodName(){
	  return "jingdong.seller.product.sku.write.updateSkuList";
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
    	                        
	public function setSpuId($spuId){
		$this->spuId = $spuId;
         $this->apiParas["spuId"] = $spuId;
	}

	public function getSpuId(){
	  return $this->spuId;
	}

                                                 	                        	                                                                                                                                                                                                                                                                                                               private $costPrice;
                              public function setCostPrice($costPrice ){
                 $this->costPrice=$costPrice;
                 $this->apiParas["costPrice"] = $costPrice;
              }

              public function getCostPrice(){
              	return $this->costPrice;
              }
                                                                                                                                                                                                                                                                                                                                              private $sellerSkuId;
                              public function setSellerSkuId($sellerSkuId ){
                 $this->sellerSkuId=$sellerSkuId;
                 $this->apiParas["sellerSkuId"] = $sellerSkuId;
              }

              public function getSellerSkuId(){
              	return $this->sellerSkuId;
              }
                                                                                                                                                                                                                                                                                                                                              private $skuName;
                              public function setSkuName($skuName ){
                 $this->skuName=$skuName;
                 $this->apiParas["skuName"] = $skuName;
              }

              public function getSkuName(){
              	return $this->skuName;
              }
                                                                                                                                                                                                                                                                                                                                              private $jdPrice;
                              public function setJdPrice($jdPrice ){
                 $this->jdPrice=$jdPrice;
                 $this->apiParas["jdPrice"] = $jdPrice;
              }

              public function getJdPrice(){
              	return $this->jdPrice;
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





        
 

