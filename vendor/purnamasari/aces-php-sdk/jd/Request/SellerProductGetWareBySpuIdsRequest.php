<?php
 namespace Purnamasari\JD\Request;

class SellerProductGetWareBySpuIdsRequest
{
	private $apiParas = array();
	
	public function getApiMethodName(){
	  return "jingdong.seller.product.getWareBySpuIds";
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
                                                                                                                                                            		                                    	                   			private $spuDescription;
    	                        
	public function setSpuDescription($spuDescription){
		$this->spuDescription = $spuDescription;
         $this->apiParas["spuDescription"] = $spuDescription;
	}

	public function getSpuDescription(){
	  return $this->spuDescription;
	}

                        	                   			private $spuImgs;
    	                        
	public function setSpuImgs($spuImgs){
		$this->spuImgs = $spuImgs;
         $this->apiParas["spuImgs"] = $spuImgs;
	}

	public function getSpuImgs(){
	  return $this->spuImgs;
	}

                        	                   			private $brandInfo;
    	                        
	public function setBrandInfo($brandInfo){
		$this->brandInfo = $brandInfo;
         $this->apiParas["brandInfo"] = $brandInfo;
	}

	public function getBrandInfo(){
	  return $this->brandInfo;
	}

                        	                   			private $skuIds;
    	                        
	public function setSkuIds($skuIds){
		$this->skuIds = $skuIds;
         $this->apiParas["skuIds"] = $skuIds;
	}

	public function getSkuIds(){
	  return $this->skuIds;
	}

                                                    	}





        
 

