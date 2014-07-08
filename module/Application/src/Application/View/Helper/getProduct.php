<?php
namespace Application\View\Helper;
use Zend\Form\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceManager;
use Production\Model\ProductTable;

class getProduct extends AbstractHelper
{
	
	protected $serviceLocator;
	public function setServiceLocator(ServiceManager $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
	}
	
	//test
	public function Translate($data, $field)
	{
		$value = '';
		$translator = $this->serviceLocator->get('translator');
		$locale = $translator->getLocale();
		if($locale == 'km_KH' && $field == true)
		{
			$value = $data['kh_'.$field];
			if(empty($value)){
				$value = $data[$field];
			}
		}else{
			$value  = $data[$field];
			if(empty($value)){
				$value = $data["kh_" .$field];
			}
		}
	
		return $value;
	}
	
	public function __invoke($path)
	{
		
		$sm = $this->serviceLocator->get('Production\Model\ProductTable');
		$getCate = $sm->getCate();
		$getCateZeroCount = $sm->getCateZeroCount();
		$count = count($getCateZeroCount);
		$row = "<div class='row' style='margin-bottom: 15px;margin-top:15px'>";
		$col = $allRow = "";
		$i = 1;$n = 1;
		foreach ($getCate as $key=> $val)
		{
			$href = $path .'/products?cateId='. $val['category_id'];
				if($val['cate_parent'] == 0){
					$loop = "
					<div class='col-md-6 text-center'>
						<a href=".$href.">
							<div style='cursor: pointer;margin:0 auto;border-radius: 50%;margin-top:5px;margin-bottom:5px;background: url(".$path.'/img/uploads/'.$val['cate_image'].") no-repeat center;background-size:cover; height:111px; width: 111px;'>
							</div>
							<article class='green-dark'>
								<b><label class='black'>". ($n++) . "&nbsp;&nbsp;</label>".$this->Translate($val, 'cate_name')."</b>
							</article>
						</a>
						<p class='text-center' style='word-wrap: break-word'>
							".$this->Translate($val, 'cate_details')."
						</p>
					</div> ";
					$col .= $loop;
					if($i%2 == 0 || $i == $count){
						$allRow .= $row.$col. "</div>";
						$col = "";
					}
					$i++;
				}
			}
			echo $allRow;
	}
}