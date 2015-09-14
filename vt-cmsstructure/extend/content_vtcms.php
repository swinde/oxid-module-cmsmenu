<?php

class content_vtcms extends content_vtcms_parent
{

	public function getBreadCrumb()
	{
		$oContent = $this->getContent();

		$aPaths = array();
		$aPath = array();

		if ($oContent->oxcontents__oxparentloadid->value)
        {
			$oParent = oxNew("oxContent");
			$oParent->loadByIdent($oContent->oxcontents__oxparentloadid->value);

			$aParent['title'] = $oParent->oxcontents__oxtitle->value;
			$aParent['link'] = $oParent->getLink();
			$aPaths[] = $aParent;
		}

		$aPath['title'] = $oContent->oxcontents__oxtitle->value;
		$aPath['link'] = $this->getLink();
		$aPaths[] = $aPath;

		return $aPaths;
	}

    public function getRootContent()
    {
        /** @var oxContent $act */
        $act = $this->getContent();
        // only first level of "upper menu" content pages should have this type, all other arer just subpages
        $sParent = ($act->oxcontents__oxtype->value == 1) ? false : $act->oxcontents__oxparentloadid->value ;

        while($sParent)
        {
            $act = oxNew("oxcontent");
            $act->loadByIdent($sParent);
            $sParent = ($act->oxcontents__oxtype->value == 1) ? false : $act->oxcontents__oxparentloadid->value;
        }

        return $act;
    }

    public function getRootContentId()
    {
        return $this->getRootContent()->getId();
    }

    public function getRootContentLoadId()
    {
        return $this->getRootContent()->getLoadId();
    }

}