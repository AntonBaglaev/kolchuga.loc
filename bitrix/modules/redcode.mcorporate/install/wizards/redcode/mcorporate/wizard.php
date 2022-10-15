<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/install/wizard_sol/wizard.php");

class SelectSiteStep extends CSelectSiteWizardStep
{
	function InitStep()
	{
		parent::InitStep();

		$wizard =& $this->GetWizard();
		$wizard->solutionName = "mcorporate";
	}

	function ShowStep()
	{
		parent::ShowStep();

		if(!\Bitrix\Main\Loader::includeSharewareModule("redcode.mcorporate"))
		{
			$this->content = '
				<script type="text/javascript">
					function ready(){
						var button = document.getElementsByClassName("wizard-next-button")[0];
						button.style.display = "none";
					}
					document.addEventListener("DOMContentLoaded", ready);
				</script>
			';
			$this->content .= "
				Решение \"redcode.mcorporate\" не установлено! <br><br>
				Пожалуйста, перейдите по пути (Marketplace -> Установленные решения) и установите решение \"redcode.mcorporate\".
			";
		}
	}
}
	
class SelectTemplateStep extends CSelectTemplateWizardStep
{
	function ShowStep()
	{
		parent::ShowStep();

		if(!\Bitrix\Main\Loader::includeSharewareModule("redcode.mcorporate"))
		{
			$this->content = '
				<script type="text/javascript">
					function ready(){
						var button = document.getElementsByClassName("wizard-next-button")[0];
						button.style.display = "none";
					}
					document.addEventListener("DOMContentLoaded", ready);
				</script>
			';
			$this->content .= "
				Решение \"redcode.mcorporate\" не установлено! <br><br>
				Пожалуйста, перейдите по пути (Marketplace -> Установленные решения) и установите решение \"redcode.mcorporate\".
			";
		}
	}
}

class SelectThemeStep extends CSelectThemeWizardStep{}

class SiteSettingsStep extends CSiteSettingsWizardStep
{
	function InitStep()
	{
		$wizard =& $this->GetWizard();
		$wizard->solutionName = "mcorporate";
		parent::InitStep();
		
		/* SET DEFAULT SITE VALUES */
		$siteID = $wizard->GetVar("siteID");
		if(strlen($siteID) > 0){
            $obSite = new CSite();
            $obSite->Update($siteID, array("SITE_NAME" => GetMessage("WIZARD_SITE_NAME")));
        }
			
		$wizard->SetDefaultVars(
			array(
				"sitePhone" => GetMessage("WIZARD_COMPANY_NUMBER_DEF"),
				"siteAddress" => GetMessage("WIZARD_COMPANY_ADDRESS_DEF"),
				"siteEmail" => GetMessage("WIZARD_COMPANY_EMAIL_DEF"),
				"siteWorkingHours" => GetMessage("WIZARD_COMPANY_WORKINGHOURS_DEF"),
				"siteMetaDescription" => GetMessage("WIZARD_SITE_DESCRIPTION"),
				"siteMetaKeywords" => GetMessage("WIZARD_SITE_KEYWORDS"), 
			)
		);
	}

	function ShowStep()
	{
		$wizard =& $this->GetWizard();

		$this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("WIZARD_COMPANY_LOGO").'</div>';
		$this->content .= "<br />".$this->ShowFileField("siteLogo", array("show_file_info" => "N", "id" => "site-logo"))."</div>";

		$this->content .= '<div class="wizard-input-form-block"><div class="wizard-catalog-title">'.GetMessage("WIZARD_COMPANY_NUMBER").'</div>';
		$this->content .= $this->ShowInputField("textarea", "sitePhone", array("id" => "site-phone", "class" => "wizard-field", "rows" => "3"))."</div>";
		
		$this->content .= '<div class="wizard-input-form-block"><div class="wizard-catalog-title">'.GetMessage("WIZARD_COMPANY_EMAIL").'</div>';
		$this->content .= $this->ShowInputField("textarea", "siteEmail", array("id" => "site-email", "class" => "wizard-field", "rows" => "3"))."</div>";
		
		$this->content .= '<div class="wizard-input-form-block"><div class="wizard-catalog-title">'.GetMessage("WIZARD_COMPANY_ADDRESS").'</div>';
		$this->content .= $this->ShowInputField("textarea", "siteAddress", array("id" => "site-address", "class" => "wizard-field", "rows" => "3"))."</div>";
		
		$this->content .= '<div class="wizard-input-form-block"><div class="wizard-catalog-title">'.GetMessage("WIZARD_COMPANY_WORKINGHOURS").'</div>';
		$this->content .= $this->ShowInputField("textarea", "siteWorkingHours", array("id" => "site-workinghours", "class" => "wizard-field", "rows" => "3"))."</div>";		
		
		$this->content .= '
		<div id="bx_metadata">
			<div class="wizard-input-form-block">
				<div class="wizard-metadata-title">'.GetMessage("WIZARD_META_DATA").'</div>
				<div class="wizard-upload-img-block">
					<label for="siteMetaDescription" class="wizard-input-title">'.GetMessage("WIZARD_META_DESCRIPTION").'</label>
					'.$this->ShowInputField("textarea", "siteMetaDescription", array("id" => "siteMetaDescription", "class" => "wizard-field", "rows" => "3")).'
				</div>';

		$this->content .= '
				<div class="wizard-upload-img-block">
					<label for="siteMetaKeywords" class="wizard-input-title">'.GetMessage("WIZARD_META_KEYWORDS").'</label><br>
					'.$this->ShowInputField("text", "siteMetaKeywords", array("id" => "siteMetaKeywords", "class" => "wizard-field")).'
				</div>
			</div>
		</div>';
		

		$this->content .= $this->ShowHiddenField("installDemoData", "Y");

		$formName = $wizard->GetFormName();
		$installCaption = $this->GetNextCaption();
		$nextCaption = GetMessage("NEXT_BUTTON");
	}
	
	/* SAVING THE LOGO WITH THE TASK OF HEIGHT, WIDTH */
	function OnPostForm()
	{
		$wizard =& $this->GetWizard();
		$this->SaveFile("siteLogo", array("extensions" => "gif,jpg,jpeg,png", "max_height" => 210, "max_width" => 460, "make_preview" => "Y"));
	}
}

class DataInstallStep extends CDataInstallWizardStep
{
	function CorrectServices(&$arServices)
	{
		$wizard =& $this->GetWizard();
		if($wizard->GetVar("installDemoData") != "Y"){}
	}
}

class FinishStep extends CFinishWizardStep{}