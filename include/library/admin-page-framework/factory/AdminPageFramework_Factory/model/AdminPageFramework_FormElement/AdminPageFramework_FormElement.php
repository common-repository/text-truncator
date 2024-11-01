<?php
/**
 Admin Page Framework v3.5.10b by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
class TextTruncator_AdminPageFramework_FormElement extends TextTruncator_AdminPageFramework_FormElement_Base {
    static public $_aStructure_Section = array('section_id' => '_default', '_fields_type' => null, 'page_slug' => null, 'tab_slug' => null, 'section_tab_slug' => null, 'title' => null, 'description' => null, 'capability' => null, 'if' => true, 'order' => null, 'help' => null, 'help_aside' => null, 'repeatable' => null, 'attributes' => array('class' => null, 'style' => null, 'tab' => array(),), 'class' => array('tab' => array(),), 'hidden' => false, 'collapsible' => false, '_is_first_index' => false, '_is_last_index' => false,);
    static public $_aStructure_CollapsibleArguments = array('title' => null, 'is_collapsed' => true, 'toggle_all_button' => null, 'collapse_others_on_expand' => true, 'container' => 'sections');
    static public $_aStructure_Field = array('field_id' => null, 'type' => null, 'section_id' => null, 'section_title' => null, 'page_slug' => null, 'tab_slug' => null, 'option_key' => null, 'class_name' => null, 'capability' => null, 'title' => null, 'tip' => null, 'description' => null, 'error_message' => null, 'before_label' => null, 'after_label' => null, 'if' => true, 'order' => null, 'default' => null, 'value' => null, 'help' => null, 'help_aside' => null, 'repeatable' => null, 'sortable' => null, 'show_title_column' => true, 'hidden' => null, '_fields_type' => null, '_section_index' => null, 'attributes' => null, 'class' => array('fieldrow' => array(), 'fieldset' => array(), 'fields' => array(), 'field' => array(),), '_caller_object' => null, '_nested_depth' => 0,);
    public $aFields = array();
    public $aSections = array('_default' => array(),);
    public $aConditionedFields = array();
    public $aConditionedSections = array();
    public $sFieldsType = '';
    protected $_sTargetSectionID = '_default';
    public $sCapability = 'manage_option';
    public function __construct($sFieldsType, $sCapability, $oCaller = null) {
        $this->sFieldsType = $sFieldsType;
        $this->sCapability = $sCapability;
        $this->oCaller = $oCaller;
    }
    public function addSection(array $aSection) {
        $aSection = $aSection + self::$_aStructure_Section;
        $aSection['section_id'] = $this->sanitizeSlug($aSection['section_id']);
        $this->aSections[$aSection['section_id']] = $aSection;
        $this->aFields[$aSection['section_id']] = $this->getElement($this->aFields, $aSection['section_id'], array());
    }
    public function removeSection($sSectionID) {
        if ('_default' === $sSectionID) {
            return;
        }
        unset($this->aSections[$sSectionID], $this->aFields[$sSectionID]);
    }
    public function addField($asField) {
        if (!is_array($asField)) {
            $this->_sTargetSectionID = $this->getAOrB(is_string($asField), $asField, $this->_sTargetSectionID);
            return $this->_sTargetSectionID;
        }
        $_aField = $asField;
        $this->_sTargetSectionID = $this->getElement($_aField, 'section_id', $this->_sTargetSectionID);
        $_aField = $this->uniteArrays(array('_fields_type' => $this->sFieldsType) + $_aField, array('section_id' => $this->_sTargetSectionID) + self::$_aStructure_Field);
        if (!isset($_aField['field_id'], $_aField['type'])) {
            return null;
        }
        $_aField['field_id'] = $this->sanitizeSlug($_aField['field_id']);
        $_aField['section_id'] = $this->sanitizeSlug($_aField['section_id']);
        $this->aFields[$_aField['section_id']][$_aField['field_id']] = $_aField;
        return $_aField;
    }
    public function removeField($sFieldID) {
        foreach ($this->aFields as $_sSectionID => $_aSubSectionsOrFields) {
            if (array_key_exists($sFieldID, $_aSubSectionsOrFields)) {
                unset($this->aFields[$_sSectionID][$sFieldID]);
            }
            foreach ($_aSubSectionsOrFields as $_sIndexOrFieldID => $_aSubSectionOrFields) {
                if ($this->isNumericInteger($_sIndexOrFieldID)) {
                    if (array_key_exists($sFieldID, $_aSubSectionOrFields)) {
                        unset($this->aFields[$_sSectionID][$_sIndexOrFieldID]);
                    }
                    continue;
                }
            }
        }
    }
    public function format() {
        $this->aSections = $this->formatSections($this->aSections, $this->sFieldsType, $this->sCapability);
        $this->aFields = $this->formatFields($this->aFields, $this->sFieldsType, $this->sCapability);
    }
    public function formatSections(array $aSections, $sFieldsType, $sCapability) {
        $_aNewSectionArray = array();
        foreach ($aSections as $_sSectionID => $_aSection) {
            if (!is_array($_aSection)) {
                continue;
            }
            $_aSection = $this->formatSection($_aSection, $sFieldsType, $sCapability, count($_aNewSectionArray));
            if (empty($_aSection)) {
                continue;
            }
            $_aNewSectionArray[$_sSectionID] = $_aSection;
        }
        uasort($_aNewSectionArray, array($this, '_sortByOrder'));
        return $_aNewSectionArray;
    }
    protected function formatSection(array $aSection, $sFieldsType, $sCapability, $iCountOfElements) {
        $aSection = $this->uniteArrays($aSection, array('_fields_type' => $sFieldsType, 'capability' => $sCapability,), self::$_aStructure_Section);
        $aSection['order'] = $this->getAOrB(is_numeric($aSection['order']), $aSection['order'], $iCountOfElements + 10);
        if (empty($aSection['collapsible'])) {
            $aSection['collapsible'] = $aSection['collapsible'];
        } else {
            $aSection['collapsible'] = $this->getAsArray($aSection['collapsible']) + array('title' => $aSection['title'],) + self::$_aStructure_CollapsibleArguments;
            $aSection['collapsible']['toggle_all_button'] = implode(',', $this->getAsArray($aSection['collapsible']['toggle_all_button']));
        }
        $aSection['class'] = is_array($aSection['class']) ? $aSection['class'] : $this->getAsArray($aSection['class']);
        return $aSection;
    }
    public function formatFields(array $aFields, $sFieldsType, $sCapability) {
        $_aNewFields = array();
        foreach ($aFields as $_sSectionID => $_aSubSectionsOrFields) {
            if (!isset($this->aSections[$_sSectionID])) {
                continue;
            }
            $_aNewFields[$_sSectionID] = $this->getElementAsArray($_aNewFields, $_sSectionID, array());
            $_abSectionRepeatable = $this->aSections[$_sSectionID]['repeatable'];
            if (count($this->getIntegerKeyElements($_aSubSectionsOrFields)) || $_abSectionRepeatable) {
                foreach ($this->numerizeElements($_aSubSectionsOrFields) as $_iSectionIndex => $_aFields) {
                    foreach ($_aFields as $_aField) {
                        $_iCountElement = count($this->getElementAsArray($_aNewFields, array($_sSectionID, $_iSectionIndex), array()));
                        $_aField = $this->formatField($_aField, $sFieldsType, $sCapability, $_iCountElement, $_iSectionIndex, $_abSectionRepeatable, $this->oCaller);
                        if (!empty($_aField)) {
                            $_aNewFields[$_sSectionID][$_iSectionIndex][$_aField['field_id']] = $_aField;
                        }
                    }
                    uasort($_aNewFields[$_sSectionID][$_iSectionIndex], array($this, '_sortByOrder'));
                }
                continue;
            }
            $_aSectionedFields = $_aSubSectionsOrFields;
            foreach ($_aSectionedFields as $_sFieldID => $_aField) {
                $_iCountElement = count($this->getElementAsArray($_aNewFields, $_sSectionID, array()));
                $_aField = $this->formatField($_aField, $sFieldsType, $sCapability, $_iCountElement, null, $_abSectionRepeatable, $this->oCaller);
                if (!empty($_aField)) {
                    $_aNewFields[$_sSectionID][$_aField['field_id']] = $_aField;
                }
            }
            uasort($_aNewFields[$_sSectionID], array($this, '_sortByOrder'));
        }
        $this->_sortFieldsBySectionsOrder($_aNewFields, $this->aSections);
        return $_aNewFields;
    }
    private function _sortFieldsBySectionsOrder(array & $aFields, array $aSections) {
        if (empty($aSections) || empty($aFields)) {
            return;
        }
        $_aSortedFields = array();
        foreach ($aSections as $_sSectionID => $_aSeciton) {
            if (isset($aFields[$_sSectionID])) {
                $_aSortedFields[$_sSectionID] = $aFields[$_sSectionID];
            }
        }
        $aFields = $_aSortedFields;
    }
    protected function formatField($aField, $sFieldsType, $sCapability, $iCountOfElements, $iSectionIndex, $bIsSectionRepeatable, $oCallerObject) {
        if (!isset($aField['field_id'], $aField['type'])) {
            return;
        }
        $_aField = $this->uniteArrays(array('_fields_type' => $sFieldsType, '_caller_object' => $oCallerObject,) + $aField, array('capability' => $sCapability, 'section_id' => '_default', '_section_index' => $iSectionIndex, '_section_repeatable' => $bIsSectionRepeatable,) + self::$_aStructure_Field);
        $_aField['field_id'] = $this->sanitizeSlug($_aField['field_id']);
        $_aField['section_id'] = $this->sanitizeSlug($_aField['section_id']);
        $_aField['tip'] = esc_attr(strip_tags($this->getElement($_aField, 'tip', is_array($_aField['description']) ? implode('&#10;', $_aField['description']) : $_aField['description'])));
        $_aField['order'] = $this->getAOrB(is_numeric($_aField['order']), $_aField['order'], $iCountOfElements + 10);
        return $_aField;
    }
    public function applyConditions() {
        return $this->getConditionedFields($this->getAsArray($this->aFields), $this->getConditionedSections($this->getAsArray($this->aSections)));
    }
    public function getConditionedSections(array $aSections = array()) {
        $_aNewSections = array();
        foreach ($aSections as $_sSectionID => $_aSection) {
            $_aSection = $this->getConditionedSection($_aSection);
            if (!empty($_aSection)) {
                $_aNewSections[$_sSectionID] = $_aSection;
            }
        }
        $this->aConditionedSections = $_aNewSections;
        return $_aNewSections;
    }
    protected function getConditionedSection(array $aSection) {
        if (!current_user_can($aSection['capability'])) {
            return array();
        }
        if (!$aSection['if']) {
            return array();
        }
        return $aSection;
    }
    public function getConditionedFields(array $aFields, array $aSections) {
        $aFields = $this->castArrayContents($aSections, $aFields);
        $_aNewFields = array();
        foreach ($aFields as $_sSectionID => $_aSubSectionOrFields) {
            if (!is_array($_aSubSectionOrFields)) {
                continue;
            }
            $this->_setConditionedFields($_aNewFields, $_aSubSectionOrFields, $_sSectionID);
        }
        $this->aConditionedFields = $_aNewFields;
        return $_aNewFields;
    }
    private function _setConditionedFields(array & $_aNewFields, $_aSubSectionOrFields, $_sSectionID) {
        foreach ($_aSubSectionOrFields as $_sIndexOrFieldID => $_aSubSectionOrField) {
            if ($this->isNumericInteger($_sIndexOrFieldID)) {
                $_sSubSectionIndex = $_sIndexOrFieldID;
                $_aFields = $_aSubSectionOrField;
                foreach ($_aFields as $_aField) {
                    $_aField = $this->getConditionedField($_aField);
                    if (!empty($_aField)) {
                        $_aNewFields[$_sSectionID][$_sSubSectionIndex][$_aField['field_id']] = $_aField;
                    }
                }
                continue;
            }
            $_aField = $_aSubSectionOrField;
            $_aField = $this->getConditionedField($_aField);
            if (!empty($_aField)) {
                $_aNewFields[$_sSectionID][$_aField['field_id']] = $_aField;
            }
        }
    }
    protected function getConditionedField(array $aField) {
        if (!current_user_can($aField['capability'])) {
            return array();
        }
        if (!$aField['if']) {
            return array();
        }
        return $aField;
    }
    public function setDynamicElements($aOptions) {
        $aOptions = $this->castArrayContents($this->aConditionedSections, $aOptions);
        foreach ($aOptions as $_sSectionID => $_aSubSectionOrFields) {
            $_aSubSection = $this->_getSubSectionFromOptions($_sSectionID, $this->getAsArray($_aSubSectionOrFields));
            if (empty($_aSubSection)) {
                continue;
            }
            $this->aConditionedFields[$_sSectionID] = $_aSubSection;
        }
    }
    private function _getSubSectionFromOptions($_sSectionID, array $_aSubSectionOrFields) {
        $_aSubSection = array();
        $_iPrevIndex = null;
        foreach ($_aSubSectionOrFields as $_isIndexOrFieldID => $_aSubSectionOrFieldOptions) {
            if (!$this->isNumericInteger($_isIndexOrFieldID)) {
                continue;
            }
            $_iIndex = $_isIndexOrFieldID;
            $_aSubSection[$_iIndex] = $this->_getSubSectionItemsFromOptions($_aSubSection, $_sSectionID, $_iIndex, $_iPrevIndex);
            foreach ($_aSubSection[$_iIndex] as & $_aField) {
                $_aField['_section_index'] = $_iIndex;
            }
            unset($_aField);
            $_iPrevIndex = $_iIndex;
        }
        return $_aSubSection;
    }
    private function _getSubSectionItemsFromOptions(array $_aSubSection, $_sSectionID, $_iIndex, $_iPrevIndex) {
        $_aFields = isset($this->aConditionedFields[$_sSectionID][$_iIndex]) ? $this->aConditionedFields[$_sSectionID][$_iIndex] : $this->getNonIntegerKeyElements($this->aConditionedFields[$_sSectionID]);
        return !empty($_aFields) ? $_aFields : $this->getElementAsArray($_aSubSection, $_iPrevIndex, array());
    }
}