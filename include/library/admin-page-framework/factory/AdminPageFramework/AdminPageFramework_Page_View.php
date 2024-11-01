<?php
/**
 Admin Page Framework v3.5.10b by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
abstract class TextTruncator_AdminPageFramework_Page_View extends TextTruncator_AdminPageFramework_Page_View_MetaBox {
    protected function _renderPage($sPageSlug, $sTabSlug = null) {
        $this->oUtil->addAndDoActions($this, $this->oUtil->getFilterArrayByPrefix('do_before_', $this->oProp->sClassName, $sPageSlug, $sTabSlug, true), $this); ?>
        <div class="<?php echo esc_attr($this->oProp->sWrapperClassAttribute); ?>">
            <?php
        $sContentTop = $this->_getScreenIcon($sPageSlug);
        $sContentTop.= $this->_getPageHeadingTabs($sPageSlug, $this->oProp->sPageHeadingTabTag);
        $sContentTop.= $this->_getInPageTabs($sPageSlug, $this->oProp->sInPageTabTag);
        echo $this->oUtil->addAndApplyFilters($this, $this->oUtil->getFilterArrayByPrefix('content_top_', $this->oProp->sClassName, $sPageSlug, $sTabSlug, false), $sContentTop); ?>
            <div class="admin-page-framework-container">    
                <?php
        $this->oUtil->addAndDoActions($this, $this->oUtil->getFilterArrayByPrefix('do_form_', $this->oProp->sClassName, $sPageSlug, $sTabSlug, true), $this);
        $this->_printFormOpeningTag($this->oProp->bEnableForm); ?>
                <div id="poststuff">
                    <div id="post-body" class="metabox-holder columns-<?php echo $this->_getNumberOfColumns(); ?>">
                    <?php
        $this->_printMainPageContent($sPageSlug, $sTabSlug);
        $this->_printMetaBox('side', 1);
        $this->_printMetaBox('normal', 2);
        $this->_printMetaBox('advanced', 3); ?>     
                    </div><!-- #post-body -->    
                </div><!-- #poststuff -->
                
            <?php echo $this->_printFormClosingTag($sPageSlug, $sTabSlug, $this->oProp->bEnableForm); ?>
            </div><!-- .admin-page-framework-container -->
                
            <?php echo $this->oUtil->addAndApplyFilters($this, $this->oUtil->getFilterArrayByPrefix('content_bottom_', $this->oProp->sClassName, $sPageSlug, $sTabSlug, false), ''); ?>
        </div><!-- .wrap -->
        <?php
        $this->oUtil->addAndDoActions($this, $this->oUtil->getFilterArrayByPrefix('do_after_', $this->oProp->sClassName, $sPageSlug, $sTabSlug, true), $this);
    }
    private function _printMainPageContent($sPageSlug, $sTabSlug) {
        $_bSideMetaboxExists = (isset($GLOBALS['wp_meta_boxes'][$GLOBALS['page_hook']]['side']) && count($GLOBALS['wp_meta_boxes'][$GLOBALS['page_hook']]['side']) > 0);
        echo "<!-- main admin page content -->";
        echo "<div class='admin-page-framework-content'>";
        if ($_bSideMetaboxExists) {
            echo "<div id='post-body-content'>";
        }
        $_sContent = call_user_func_array(array($this, 'content'), array($this->_getMainPageContentOutput($sPageSlug)));
        echo $this->oUtil->addAndApplyFilters($this, $this->oUtil->getFilterArrayByPrefix('content_', $this->oProp->sClassName, $sPageSlug, $sTabSlug, false), $_sContent);
        $this->oUtil->addAndDoActions($this, $this->oUtil->getFilterArrayByPrefix('do_', $this->oProp->sClassName, $sPageSlug, $sTabSlug, true), $this);
        if ($_bSideMetaboxExists) {
            echo "</div><!-- #post-body-content -->";
        }
        echo "</div><!-- .admin-page-framework-content -->";
    }
    private function _getMainPageContentOutput($sPageSlug) {
        ob_start();
        echo $this->_getFormOutput($sPageSlug);
        $_sContent = ob_get_contents();
        ob_end_clean();
        return $_sContent;
    }
    private function _getFormOutput($sPageSlug) {
        if (!$this->oProp->bEnableForm) {
            return '';
        }
        if (!$this->oForm->isPageAdded($sPageSlug)) {
            return '';
        }
        $this->aFieldErrors = isset($this->aFieldErrors) ? $this->aFieldErrors : $this->_getFieldErrors($sPageSlug);
        $_oFieldsTable = new TextTruncator_AdminPageFramework_FormTable($this->oProp->aFieldTypeDefinitions, $this->aFieldErrors, $this->oMsg);
        return $_oFieldsTable->getFormTables($this->oForm->aConditionedSections, $this->oForm->aConditionedFields, array($this, '_replyToGetSectionHeaderOutput'), array($this, '_replyToGetFieldOutput'));
    }
    private function _printFormOpeningTag($fEnableForm = true) {
        if (!$fEnableForm) {
            return;
        }
        echo "<form " . $this->oUtil->generateAttributes(array('method' => 'post', 'enctype' => $this->oProp->sFormEncType, 'id' => 'admin-page-framework-form', 'action' => wp_unslash(remove_query_arg('settings-updated', $this->oProp->sTargetFormPage)),)) . " >";
        settings_fields($this->oProp->sOptionKey);
    }
    private function _printFormClosingTag($sPageSlug, $sTabSlug, $fEnableForm = true) {
        if (!$fEnableForm) {
            return;
        }
        $_sNonceTransientKey = 'form_' . md5($this->oProp->sClassName . get_current_user_id());
        $_sNonce = $this->oUtil->getTransient($_sNonceTransientKey, '_admin_page_framework_form_nonce_' . uniqid());
        $this->oUtil->setTransient($_sNonceTransientKey, $_sNonce, 60 * 60);
        echo "<input type='hidden' name='page_slug' value='{$sPageSlug}' />" . PHP_EOL . "<input type='hidden' name='tab_slug' value='{$sTabSlug}' />" . PHP_EOL . "<input type='hidden' name='_is_admin_page_framework' value='{$_sNonce}' />" . PHP_EOL . "</form><!-- End Form -->" . PHP_EOL;
    }
    private function _getScreenIcon($sPageSlug) {
        try {
            $this->_throwScreenIconByURLOrPath($sPageSlug);
            $this->_throwScreenIconByID($sPageSlug);
        }
        catch(Exception $_oException) {
            return $_oException->getMessage();
        }
        return $this->_getDefaultScreenIcon();
    }
    private function _throwScreenIconByURLOrPath($sPageSlug) {
        if (!isset($this->oProp->aPages[$sPageSlug]['href_icon_32x32'])) {
            return;
        }
        $_aAttributes = array('style' => $this->oUtil->generateInlineCSS(array('background-image' => "url('" . esc_url($this->oProp->aPages[$sPageSlug]['href_icon_32x32']) . "')")));
        throw new Exception($this->_getScreenIconByAttributes($_aAttributes));
    }
    private function _throwScreenIconByID($sPageSlug) {
        if (!isset($this->oProp->aPages[$sPageSlug]['screen_icon_id'])) {
            return;
        }
        $_aAttributes = array('id' => "icon-" . $this->oProp->aPages[$sPageSlug]['screen_icon_id'],);
        throw new Exception($this->_getScreenIconByAttributes($_aAttributes));
    }
    private function _getDefaultScreenIcon() {
        $_oScreen = get_current_screen();
        $_sIconIDAttribute = $this->_getScreenIDAttribute($_oScreen);
        $_aAttributes = array('class' => $this->oUtil->generateClassAttribute($this->oUtil->getAOrB(empty($_sIconIDAttribute) && $_oScreen->post_type, sanitize_html_class('icon32-posts-' . $_oScreen->post_type), ''), $this->oUtil->getAOrB(empty($_sIconIDAttribute) || $_sIconIDAttribute == $this->oProp->sClassName, 'generic', '')), 'id' => "icon-" . $_sIconIDAttribute,);
        return $this->_getScreenIconByAttributes($_aAttributes);
    }
    private function _getScreenIDAttribute($oScreen) {
        if (!empty($oScreen->parent_base)) {
            return $oScreen->parent_base;
        }
        if ('page' === $oScreen->post_type) {
            return 'edit-pages';
        }
        return esc_attr($oScreen->base);
    }
    private function _getScreenIconByAttributes(array $aAttributes) {
        $aAttributes['class'] = $this->oUtil->generateClassAttribute('icon32', $this->oUtil->getElement($aAttributes, 'class'));
        return "<div " . $this->oUtil->generateAttributes($aAttributes) . ">" . "<br />" . "</div>";
    }
    private function _getPageHeadingTabs($sCurrentPageSlug, $sTag = 'h2') {
        $_aPage = $this->oProp->aPages[$sCurrentPageSlug];
        if (!$_aPage['show_page_title']) {
            return "";
        }
        $sTag = $this->_getPageHeadingTabTag($sTag, $_aPage);
        if (!$_aPage['show_page_heading_tabs'] || count($this->oProp->aPages) == 1) {
            return "<{$sTag}>" . $_aPage['title'] . "</{$sTag}>";
        }
        return $this->_getPageHeadingtabNavigationBar($this->oProp->aPages, $sTag, $sCurrentPageSlug);
    }
    private function _getPageHeadingTabTag($sTag, array $aPage) {
        return tag_escape($aPage['page_heading_tab_tag'] ? $aPage['page_heading_tab_tag'] : $sTag);
    }
    private function _getPageHeadingtabNavigationBar(array $aPages, $sTag, $sCurrentPageSlug) {
        $_aOutput = array();
        foreach ($aPages as $aSubPage) {
            $_aOutput[] = $this->_getPageHeadingtabNavigationBarItem($aSubPage, $sCurrentPageSlug);
        }
        $_aOutput = array_filter($_aOutput);
        return empty($_aOutput) ? '' : "<div class='admin-page-framework-page-heading-tab'>" . "<{$sTag} class='nav-tab-wrapper'>" . implode('', $_aOutput) . "</{$sTag}>" . "</div>";
    }
    private function _getPageHeadingtabNavigationBarItem(array $aSubPage, $sCurrentPageSlug) {
        switch ($aSubPage['type']) {
            case 'link':
                return $this->_getPageHeadingtabNavigationBarLinkItem($aSubPage);
            default:
                return $this->_getPageHeadingtabNavigationBarPageItem($aSubPage, $sCurrentPageSlug);
        }
    }
    private function _getPageHeadingtabNavigationBarPageItem(array $aSubPage, $sCurrentPageSlug) {
        if (!isset($aSubPage['page_slug'])) {
            return '';
        }
        if (!$aSubPage['show_page_heading_tab']) {
            return '';
        }
        return "<a " . $this->oUtil->generateAttributes(array('class' => $this->oUtil->generateClassAttribute('nav-tab', $this->oUtil->getAOrB($sCurrentPageSlug === $aSubPage['page_slug'], 'nav-tab-active', '')), 'href' => esc_url($this->oUtil->getQueryAdminURL(array('page' => $aSubPage['page_slug'], 'tab' => false,), $this->oProp->aDisallowedQueryKeys)),)) . ">" . $aSubPage['title'] . "</a>";
    }
    private function _getPageHeadingtabNavigationBarLinkItem(array $aSubPage) {
        if (!isset($aSubPage['href'])) {
            return '';
        }
        if (!$aSubPage['show_page_heading_tab']) {
            return '';
        }
        return "<a " . $this->oUtil->generateAttributes(array('class' => 'nav-tab link', 'href' => esc_url($aSubPage['href']),)) . ">" . $aSubPage['title'] . "</a>";
    }
    private function _getInPageTabs($sCurrentPageSlug, $sTag = 'h3') {
        $_aInPageTabs = $this->oUtil->getElement($this->oProp->aInPageTabs, $sCurrentPageSlug, array());
        if (empty($_aInPageTabs)) {
            return '';
        }
        $_aPage = $this->oProp->aPages[$sCurrentPageSlug];
        $_sCurrentTabSlug = $this->_getCurrentTabSlug($sCurrentPageSlug);
        $_sTag = $this->_getInPageTabTag($sTag, $_aPage);
        if (!$_aPage['show_in_page_tabs']) {
            return isset($_aInPageTabs[$_sCurrentTabSlug]['title']) ? "<{$_sTag}>" . $_aInPageTabs[$_sCurrentTabSlug]['title'] . "</{$_sTag}>" : "";
        }
        return $this->_getInPageTabNavigationBar($_aInPageTabs, $_sTag, $sCurrentPageSlug, $_sCurrentTabSlug);
    }
    private function _getInPageTabNavigationBar($aInPageTabs, $sTag, $sCurrentPageSlug, $sCurrentTabSlug) {
        $_aOutput = array();
        foreach ($aInPageTabs as $_sTabSlug => $_aInPageTab) {
            $_sInPageTabSlug = isset($_aInPageTab['parent_tab_slug'], $aInPageTabs[$_aInPageTab['parent_tab_slug']]) ? $_aInPageTab['parent_tab_slug'] : $_aInPageTab['tab_slug'];
            $_aOutput[$_sInPageTabSlug] = $this->_getInPageTabNavigationBarItem($aInPageTabs[$_sInPageTabSlug]['title'], $_aInPageTab, $_sInPageTabSlug, $sCurrentPageSlug, $sCurrentTabSlug);
        }
        $_aOutput = array_filter($_aOutput);
        return empty($_aOutput) ? "" : "<div class='admin-page-framework-in-page-tab'>" . "<{$sTag} class='nav-tab-wrapper in-page-tab'>" . implode('', $_aOutput) . "</{$sTag}>" . "</div>";
    }
    private function _getInPageTabNavigationBarItem($sTitle, array $aInPageTab, $sInPageTabSlug, $sCurrentPageSlug, $sCurrentTabSlug) {
        if (!$aInPageTab['show_in_page_tab'] && !isset($aInPageTab['parent_tab_slug'])) {
            return '';
        }
        return "<a " . $this->oUtil->generateAttributes(array('class' => $this->oUtil->generateClassAttribute('nav-tab', $this->oUtil->getAOrB($sCurrentTabSlug === $sInPageTabSlug, "nav-tab-active", '')), 'href' => esc_url($this->oUtil->getElement($aInPageTab, 'url', $this->oUtil->getQueryAdminURL(array('page' => $sCurrentPageSlug, 'tab' => $sInPageTabSlug,), $this->oProp->aDisallowedQueryKeys))), 'data-tab-slug' => $sInPageTabSlug,)) . ">" . $sTitle . "</a>";
    }
    private function _getInPageTabTag($sTag, array $aPage) {
        return tag_escape($aPage['in_page_tab_tag'] ? $aPage['in_page_tab_tag'] : $sTag);
    }
    private function _getCurrentTabSlug($sCurrentPageSlug) {
        $_sCurrentTabSlug = $this->oUtil->getElement($_GET, 'tab', $this->oProp->getDefaultInPageTab($sCurrentPageSlug));
        return $this->_getParentTabSlug($sCurrentPageSlug, $_sCurrentTabSlug);
    }
    private function _getParentTabSlug($sPageSlug, $sTabSlug) {
        $_sParentTabSlug = $this->oUtil->getElement($this->oProp->aInPageTabs, array($sPageSlug, $sTabSlug, 'parent_tab_slug'), $sTabSlug);
        return isset($this->oProp->aInPageTabs[$sPageSlug][$_sParentTabSlug]['show_in_page_tab']) && $this->oProp->aInPageTabs[$sPageSlug][$_sParentTabSlug]['show_in_page_tab'] ? $_sParentTabSlug : '';
    }
}