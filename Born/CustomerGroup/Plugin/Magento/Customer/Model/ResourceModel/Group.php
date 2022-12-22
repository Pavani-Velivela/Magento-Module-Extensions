<?php

namespace Born\CustomerGroup\Plugin\Magento\Customer\Model\ResourceModel;

class Group
{
	public function __construct(
		\Magento\Framework\App\RequestInterface $request
	) {
		$this->request = $request;
	}

	public function beforeSave($subject, $model)
	{
		$minPrice = $this->request->getParam('min_price', false);
		$maxPrice = $this->request->getParam('max_price', false);
		
		if ($minPrice && $maxPrice) {
			$model->setData('min_price', $minPrice);
			$model->setData('max_price', $maxPrice);
		}

		return [$model];
	}
}