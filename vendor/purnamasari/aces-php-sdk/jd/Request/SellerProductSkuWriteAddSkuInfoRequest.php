<?php
 namespace Purnamasari\JD\Request;

class SellerProductSkuWriteAddSkuInfoRequest
{
	private $apiParas = array();
	
	public function getApiMethodName(){
	  return "jingdong.seller.product.sku.write.addSkuInfo";
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

                        	                                                 	                        	                                                                                                                                                                                                                                                                                                               private $packLong;
                              public function setPackLong($packLong ){
                 $this->packLong=$packLong;
                 $this->apiParas["packLong"] = $packLong;
              }

              public function getPackLong(){
              	return $this->packLong;
              }
                                                                                                                                                                                                                                                                                                                                              private $saleAttributeIds;
                              public function setSaleAttributeIds($saleAttributeIds ){
                 $this->saleAttributeIds=$saleAttributeIds;
                 $this->apiParas["saleAttributeIds"] = $saleAttributeIds;
              }

              public function getSaleAttributeIds(){
              	return $this->saleAttributeIds;
              }
                                                                                                                                                                                                                                                                                                                                              private $costPrice;
                              public function setCostPrice($costPrice ){
                 $this->costPrice=$costPrice;
                 $this->apiParas["costPrice"] = $costPrice;
              }

              public function getCostPrice(){
              	return $this->costPrice;
              }
                                                                                                                                                                                                                                                                                                                                              private $upc;
                              public function setUpc($upc ){
                 $this->upc=$upc;
                 $this->apiParas["upc"] = $upc;
              }

              public function getUpc(){
              	return $this->upc;
              }
                                                                                                                                                                                                                                                                                                                                              private $weight;
                              public function setWeight($weight ){
                 $this->weight=$weight;
                 $this->apiParas["weight"] = $weight;
              }

              public function getWeight(){
              	return $this->weight;
              }
                                                                                                                                                                                                                                                                                                                                              private $sellerSkuId;
                              public function setSellerSkuId($sellerSkuId ){
                 $this->sellerSkuId=$sellerSkuId;
                 $this->apiParas["sellerSkuId"] = $sellerSkuId;
              }

              public function getSellerSkuId(){
              	return $this->sellerSkuId;
              }
                                                                                                                                                                                                                                                                                                                                              private $saleAttrValueAlias;
                              public function setSaleAttrValueAlias($saleAttrValueAlias ){
                 $this->saleAttrValueAlias=$saleAttrValueAlias;
                 $this->apiParas["saleAttrValueAlias"] = $saleAttrValueAlias;
              }

              public function getSaleAttrValueAlias(){
              	return $this->saleAttrValueAlias;
              }
                                                                                                                                                                                                                                                                                                                                              private $skuName;
                              public function setSkuName($skuName ){
                 $this->skuName=$skuName;
                 $this->apiParas["skuName"] = $skuName;
              }

              public function getSkuName(){
              	return $this->skuName;
              }
                                                                                                                                                                                                                                                                                                                                              private $packWide;
                              public function setPackWide($packWide ){
                 $this->packWide=$packWide;
                 $this->apiParas["packWide"] = $packWide;
              }

              public function getPackWide(){
              	return $this->packWide;
              }
                                                                                                                                                                                                                                                                                                                                              private $piece;
                              public function setPiece($piece ){
                 $this->piece=$piece;
                 $this->apiParas["piece"] = $piece;
              }

              public function getPiece(){
              	return $this->piece;
              }
                                                                                                                                                                                                                                                                                                                                              private $jdPrice;
                              public function setJdPrice($jdPrice ){
                 $this->jdPrice=$jdPrice;
                 $this->apiParas["jdPrice"] = $jdPrice;
              }

              public function getJdPrice(){
              	return $this->jdPrice;
              }
                                                                                                                                                                                                                                                                                                                                              private $packHeight;
                              public function setPackHeight($packHeight ){
                 $this->packHeight=$packHeight;
                 $this->apiParas["packHeight"] = $packHeight;
              }

              public function getPackHeight(){
              	return $this->packHeight;
              }
                                                                                                                                                                                                                                                                                                                                              private $stock;
                              public function setStock($stock ){
                 $this->stock=$stock;
                 $this->apiParas["stock"] = $stock;
              }

              public function getStock(){
              	return $this->stock;
              }
                                                                                                                }





        
 

