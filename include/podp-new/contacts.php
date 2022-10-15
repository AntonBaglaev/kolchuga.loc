<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>

<?

if (!empty($_POST['P_EMAIL'])) {
    global $USER;
    if (CModule::IncludeModule("subscribe")) {

        $USER_ID = $USER->GetID();
        $EMAIL = $_POST['P_EMAIL'];

        $arFilter = array(
            "ACTIVE" => "Y",
            "LID" => SITE_ID,
            "VISIBLE" => "Y",
        );

        $rsRubrics = CRubric::GetList(array(), $arFilter);
        $arRubrics = array();
        while ($arRubric = $rsRubrics->GetNext()){
            $arRubrics[] = $arRubric["ID"];
        }

        $obSubscription = new CSubscription;

        if ($USER_ID) {
            $rsSubscription = $obSubscription->GetList(array(), array("USER_ID" => $USER_ID));
            if ($arSubscription = $rsSubscription->Fetch()) {
                $rs = $obSubscription->Update(
                    $arSubscription["ID"],
                    array(
                        "FORMAT" => "html",
                        "RUB_ID" => $arRubrics,
                    ),
                    false
                );
            }
        } else {
            $ID = $obSubscription->Add(array(
                "ACTIVE" => "Y",
                "EMAIL" => $EMAIL,
                "FORMAT" => "html",
                "CONFIRMED" => "N",
                "SEND_CONFIRM" => "Y",
                "RUB_ID" => $arRubrics,
            ));
        }

    }
}
?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>