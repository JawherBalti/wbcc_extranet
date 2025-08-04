<div class="script-container" style="margin-top:15px; padding:10px">
                <form id="scriptForm">
                    <input hidden id="contextId" name="idCompanyGroup"
                        value="<?= $company ? $company->idCompany : 0 ?>">

                    <!-- Étape 0 : Presentation -->
                    <div class="step active">
                        <?php 
                            $consignes = "";
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify">Bonjour, je suis <b>' . $connectedUser->fullName . '</b> de la société SOS Sinistre, spécialisée dans la gestion des sinistres immobiliers. <br> J\'ai une information importante à porter à votre connaissance. <br>Est-ce que je parle bien avec ' . (!empty($contact) ? ' <b>' . $contact->prenom . ' ' . $contact->nom . '</b>' : '') . ' ?</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>
                        <?php
                            $name = 'responsable';
                            $options = [
                                [
                                    'onclick' => "",
                                    'btn_class' => 'success',
                                    'value' => 'oui',
                                    'label' => 'Oui'
                                ],
                                [
                                    'onclick' => "",
                                    'btn_class' => 'warning',
                                    'value' => 'hesite',
                                    'label' => 'Plus de précisions'
                                ],
                                [
                                    'onclick' => "",
                                    'btn_class' => 'danger',
                                    'value' => 'non',
                                    'label' => 'Non'
                                ]
                            ];
                            include dirname(__FILE__) . '/blocs/responseOptions.php';
                        ?>
                    </div>

                    <!-- Étape 1 : Oui Resp -->
                    <div class="step">
                        <?php 
                            $consignes = "";
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify">Merci. Je suis chargé de vous informer que les commerçants bénéficient désormais d\'une assistance totalement gratuite pour la gestion de leurs sinistres immobiliers (dégât des eaux, incendie, bris de glace, effraction avec dommages matériels, etc.). <br> Est-ce un sujet qui vous concerne aujourd\'hui ?</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>
                        <?php
                            $name = 'reponse_concerne';
                            $options = [
                                [
                                    'onclick' => "",
                                    'btn_class' => 'success',
                                    'value' => 'oui',
                                    'label' => 'Oui',
                                    'ref' => 'reponse_concerne'
                                ],
                                [
                                    'onclick' => "",
                                    'btn_class' => 'danger',
                                    'value' => 'non',
                                    'label' => 'Non',
                                    'ref' => 'reponse_concerne'
                                ]
                            ];
                            include dirname(__FILE__) . '/blocs/responseOptions.php';
                        ?>
                    </div>

                    <!-- Étape 2 : Oui Concerne -->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p>Nous allons pouvoir vous aider. Je vais rapidement recueillir les informations essentielles afin de pouvoir vous accompagner immédiatement et gratuitement dans la gestion de votre sinistre.<br>Tout d\'abord, quel type de sinistre avez-vous ?</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>
                        <div class="response-options">
                            <div class="col-md-10" style="margin-left: 95px; margin-bottom: 10px;">
                                <label for="typeSinistre" class="fw-bold">Choisir le type de sinistre</label>
                                <select class="form-control" id="typeSinistre" name="type_sinistre"
                                    onchange="onChangeTypeSin(); showSousQuestion('2-1',true)">
                                    <option value="">Choisir la nature du sinistre</option>
                                    <?php $selectedType = $questScript->type_sinistre ?? '';
                                    foreach ($typeSinistres as $value => $label): ?>
                                    <option value="<?= $value ?>" <?= $value == $selectedType ? 'selected' : '' ?>>
                                        <?= $label ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="text" class="form-control mt-2" id="autre-sinistre" name="autre_sinistre"
                                    placeholder="Précisez le type de sinistre" style="display: none;"
                                    onblur="showSousQuestion('2-1',true)">
                            </div>
                        </div>

                    </div>

                    <!-- Etape 3 Question Reparation -->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify" id="textConfirmPriseEnCharge">Est-ce que les travaux d\'embellissement ou de remise en état ont déjà été réalisés ?</p>';
                            include dirname(__FILE__) . '../blocs/questionContent.php';
                        ?>
                        <?php
                            $name = 'siTravaux';
                            $options = [
                                [
                                    'onclick' => "",
                                    'btn_class' => 'success',
                                    'value' => 'oui',
                                    'label' => 'Oui'
                                ],
                                [
                                    'onclick' => "",
                                    'btn_class' => 'danger',
                                    'value' => 'non',
                                    'label' => 'Non'
                                ]
                            ];
                            include dirname(__FILE__) . '/blocs/responseOptions.php';
                        ?>
                    </div>

                    <!-- Etape 4 DATE DU SINISTRE -->
                    <div class="step">
                        
                            <?php 
                                $consignes = '';
                                $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                            <p class="text-justify">Je vais recupérer des informations rapidement<br>Quelle est la date du sinistre ?</p>';
                                include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="row col-md-12 mt-2">
                                    <div class='col-md-6'>
                                        <input type='date' name='dateSinistre' id="dateS" max="<?= date('Y-m-d') ?>"
                                            value='<?= ($rt  && $rt->date != '' && $rt->date != null) ?  date('Y-m-d', strtotime(explode(" ", $rt->date)[0]))   : ($questScript && $questScript->dateSinistre != ""  ? date('Y-m-d', strtotime($questScript->dateSinistre))  : "") ?>'
                                            class='col-md-10 form-control'>
                                    </div>
                                    <div class='col-md-6 badge bg-secondary py-2 mb-3 text-white'>
                                        <input type='checkbox' name='dateInconnue' id='dateInconnu'
                                            <?= checked('dateInconnue', 'oui', $questScript, 'checked') ?> value='oui'
                                            class='checkbox' onclick='changeDateTE()'>
                                        <label for=''>Date Inconnue</label>
                                    </div>
                                </div>
                                <div class="card" id='infosCom'
                                    <?= $questScript && $questScript->dateInconnue == 'oui' ? '' : 'hidden' ?>>
                                    <div class="card-body">
                                        <div class='row mt-2'>
                                            <label for='' class='col-md-5'>a. Date approximative de constatation du
                                                sinistre : </label>
                                            <input type='date' name='dateApproximative' id='dateConstat'
                                                max="<?= date('Y-m-d') ?>"
                                                value='<?= ($rt != null && $rt != false) ? ($rt->dateConstat != '' ?  date('Y-m-d', strtotime($rt->dateConstat)) : "")  : ($questScript && $questScript->dateApproximative != "" ? date('Y-m-d', strtotime($questScript->dateApproximative))  : "")  ?>'
                                                class='offset-md-1 col-md-6 form-control'>
                                        </div>
                                        <div class='col-md-2'>OU</div>
                                        <div class='row'>
                                            <label for='' class='col-md-6'>b. Pouvez-vous nous
                                                donner au moins
                                                l'année de survenance du sinistre ?</label>
                                            <input type='text' name='anneeSurvenance' id='anneeSurvenance'
                                                value='<?= ($rt != null && $rt != false) ? $rt->anneeSurvenance  : ($questScript ? $questScript->anneeSurvenance : "") ?>'
                                                class='col-md-6 form-control'>
                                        </div>
                                        <div class='row mt-2'>
                                            <label for='' class=''>c. Expliquez-nous les raisons
                                                pour lesquelles
                                                vous n'êtes pas en mesure de nous donner la date
                                                précise du sinistre
                                                ?</label>
                                            <textarea name='commentaireDateInconnue' id='comDateInconnu' cols='30'
                                                rows='5'
                                                class='form-control'><?= ($rt != null && $rt != false) ? $rt->commentaireDateInconnue  : ($questScript ? $questScript->commentaireDateInconnue : "") ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Etape 5 : Dommages -->
                    <div class="step">
                        
                            <?php 
                                $consignes = '';
                                $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                            <p class="text-justify" id="textDommages">Qu\'est-ce que vous avez comme dommages ?</p>';
                                include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class='row col-md-12'>
                                    <!-- Dégât des eaux -->
                                    <div id="option-content" class="form-group col-md-12 row">

                                    </div>
                                    <div class="row">
                                        <div class='col-md-12' id="divAutreDommage"
                                            <?= $questScript && str_contains($questScript->dommages, 'Autre')  ? '' : 'hidden'  ?>>
                                            <div class='row'>
                                                <div class='col-md-12'>
                                                    <label for=''>Précisez Autres Dommages : </label>
                                                </div>
                                                <div class='col-md-12'>
                                                    <input value='<?= $questScript ? $questScript->autreDommage : '' ?>'
                                                        type='text' name='autreDommage' class='form-control'
                                                        id='autreDommage'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 6 : origine -->
                    <div class="step">
                        
                            <?php 
                                $consignes = '';
                                $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                            <p class="text-justify" id="textConfirmPriseEnCharge">Pouvez-vous me dire svp l\'origine du sinistre ?</p>';
                                include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="row col-md-12" id="origineSinistreDDE">
                                    <div class='col-md-6'>
                                        <div class='col-12 text-left'>
                                            <input
                                                <?= ($rt) ? (in_array('Fuite', $causes) ? 'checked' : '') : ($questScript && $questScript->causes != "" && (in_array('Fuite', explode(";", $questScript->causes))) ?  'checked' : "") ?>
                                                onchange='onClickCause(this,1)' type='checkbox' value='Fuite' id='fuite'
                                                name='cause[]' class="cause">
                                            <label>a. Fuite</label>
                                        </div>
                                        <div class='col-12 text-left'>
                                            <input
                                                <?= ($rt) ? (in_array('Infiltration', $causes)  ? 'checked' : '') : ($questScript && $questScript->causes != "" && (in_array('Infiltration', explode(";", $questScript->causes))) ?  'checked' : "") ?>
                                                onchange='onClickCause(this,1)' type='checkbox' value='Infiltration'
                                                id='infiltration' name='cause[]' class="cause">
                                            <label>c. Infiltration</label>
                                        </div>
                                        <div class='col-12 text-left'>
                                            <input
                                                <?= ($rt) ? (in_array('Engorgement', $causes)  ? 'checked' : '') : ($questScript && $questScript->causes != "" && (in_array('Engorgement', explode(";", $questScript->causes))) ?  'checked' : "") ?>
                                                onchange='onClickCause(this,1)' type='checkbox' value='Engorgement'
                                                id='engorgement' name='cause[]' class="cause">
                                            <label>e. Engorgement</label>
                                        </div>
                                    </div>
                                    <div class='col-md-6'>
                                        <div class='col-12 text-left'>
                                            <input
                                                <?= ($rt) ? (in_array('Débordement', $causes)  ? 'checked' : '') : ($questScript && $questScript->causes != "" && (in_array('Débordement', explode(";", $questScript->causes))) ?  'checked' : "") ?>
                                                onchange='onClickCause(this,1)' type='checkbox' value='Débordement'
                                                id='debordement' name='cause[]' class="cause">
                                            <label>b. Débordement</label>
                                        </div>
                                        <div class='col-12 text-left'>
                                            <input
                                                <?= ($rt) ? (in_array('je ne sais pas', $causes)  ? 'checked' : '') : ($questScript && $questScript->causes != "" && (in_array('je ne sais pas', explode(";", $questScript->causes))) ?  'checked' : "") ?>
                                                onchange='onClickCause(this,1)' type='checkbox' value='je ne sais pas'
                                                id='nesaispasCause' name='cause[]' class="cause">
                                            <label>d. Je ne sais pas</label>
                                        </div>
                                        <div class='col-12 text-left'>
                                            <input
                                                <?= ($rt) ? (in_array('Autre', $causes)  ? 'checked' : '') : ($questScript && $questScript->causes != "" && (in_array('Autre', explode(";", $questScript->causes))) ?  'checked' : "") ?>
                                                onchange='onClickCause(this,1)' type='checkbox' value='Autre' id='autre'
                                                name='cause[]' class="cause">
                                            <label>f. Autre</label>
                                        </div>

                                    </div>
                                    <div class='col-md-12'
                                        <?= ($rt) ? (in_array('Autre', $causes)  ? '' : 'hidden') : ($questScript && $questScript->causes != "" && (in_array('Autre', explode(";", $questScript->causes))) ?  '' : "hidden") ?>
                                        id="divAutreCause">
                                        <div class='row'>
                                            <div class='col-md-12'>
                                                <label for=''>Précisez Autres origines : </label>
                                            </div>
                                            <div class='col-md-12'>
                                                <input value='<?= $questScript ? $questScript->autreCauseDegat : '' ?>'
                                                    type='text' name='autreCauseDegat' class='form-control'
                                                    id='autreCauseDegat'>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 7 : Circonstantces -->
                    <div class="step">
                        
                            <?php 
                                $consignes = '';
                                $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                            <p class="text-justify" id="textConfirmPriseEnCharge">Dites-nous tout ce que vous savez sur le sinistre</p>';
                                include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <div class="response-options">
                            <div class="options-container">
                                <textarea style="white-space: normal" name='commentaireSinistre' class='form-control'
                                    id='commentaireSinistre' cols=30
                                    rows=5><?= ($rt) ?  $rt->precisionComplementaire : ($questScript ? $questScript->commentaireSinistre : "") ?></textarea>
                            </div>
                        </div>
                    </div>


                    <!-- Etape 8 : INFOS ASSURANCE -->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify">Avez-vous déclaré ce sinistre à votre assureur</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>
                        <?php
                            $name = 'siDeclarerSinistre';
                            $options = [
                                [
                                    'onclick' => "showSousQuestion('4-1',false);showSousQuestion('4-2',true);",
                                    'btn_class' => 'success',
                                    'value' => 'oui',
                                    'label' => 'Oui',
                                    'id' => 'respOui'
                                ],
                                [
                                    'onclick' => "showSousQuestion('4-1',true);showSousQuestion('4-2',false);",
                                    'btn_class' => 'danger',
                                    'value' => 'non',
                                    'label' => 'Non',
                                    'id' => 'respNon'
                                ]
                            ];
                            include dirname(__FILE__) . '/blocs/responseOptions.php';
                        ?>
                        <!-- Si Non déclaré -->
                        <div id="sous-question-4-1"
                            <?= $questScript && $questScript->siDeclarerSinistre == 'non' ? '' : 'hidden' ?>>
                            <?php 
                                $consignes = '';
                                $paragraph = '<strong>Question <span name="numQuestionScript"></span>-a :</strong>
                                            <p class="text-justify">Vous n\'avez pas encore déclaré ce sinistre à votre assurance ? Très bien, je vous propose de le faire directement pour vous dès maintenant, de façon totalement gratuite. <br>Nous gérons pour vous toute la procédure, de la déclaration à la réparation finale, en coordonnant directement les échanges avec l\'expert mandaté et en assurant rapidement les travaux nécessaires, sans frais à avancer, sauf la franchise éventuelle. C\'est exactement comme le modèle utilisé par Carglass : vous ne vous occupez de rien et nous nous chargeons de tout.<br></p>';
                                include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        </div>
                        <!-- Si  déclaré -->
                        <div id="sous-question-4-2"
                            <?= $questScript && $questScript->siDeclarerSinistre == 'oui' ? '' : 'hidden' ?>>
                            <?php 
                                $consignes = '';
                                $paragraph = '<strong>Question <span name="numQuestionScript"></span>-a :</strong>
                                            <p class="text-justify">Vous avez déjà déclaré ce sinistre à votre assureur, c\'est noté. Je vais juste vérifier quelques points importants avec vous. Votre compagnie vous a-t-elle informé de son intention de mandater son expert pour venir expertiser et évaluer votre sinistre ?</p>';
                                include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            <?php
                                $name = 'repSiMandatExpert';
                                $options = [
                                    [
                                        'onclick' => "showSousQuestion('4-2-1',true);showSousQuestion('4-2-2',false);",
                                        'btn_class' => 'success',
                                        'value' => 'oui',
                                        'label' => 'Oui',
                                        'id' => 'respOui'
                                    ],
                                    [
                                        'onclick' => "showSousQuestion('4-2-1',false);showSousQuestion('4-2-2',true);",
                                        'btn_class' => 'danger',
                                        'value' => 'non',
                                        'label' => 'Non',
                                        'id' => 'respNon'
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                                ?>

                            <!-- Si oui expert mandaté -->
                            <div id="sous-question-4-2-1"
                                <?= $questScript && $questScript->repSiMandatExpert == 'oui' ? '' : 'hidden' ?>>
                                <?php 
                                    $consignes = '';
                                    $paragraph = '<strong>Question <span name="numQuestionScript"></span>-b :</strong>
                                                <p class="text-justify">Est-ce que l\'expert mandaté par votre assurance est déjà venu constater les dommages ?</p>';
                                    include dirname(__FILE__) . '/blocs/questionContent.php';
                                    ?>
                                <?php
                                    $name = 'repSiExpertVenu';
                                    $options = [
                                        [
                                            'onclick' => "showSousQuestion('4-2-1-1',true);",
                                            'btn_class' => 'success',
                                            'value' => 'oui',
                                            'label' => 'Oui',
                                            'id' => 'respOui'
                                        ],
                                        [
                                            'onclick' => "showSousQuestion('4-2-1-1',false);",
                                            'btn_class' => 'danger',
                                            'value' => 'non',
                                            'label' => 'Non',
                                            'id' => 'respNon'
                                        ]
                                    ];
                                    include dirname(__FILE__) . '/blocs/responseOptions.php';
                                    ?>
                                <!-- Si oui constatExpert -->
                                <div id="sous-question-4-2-1-1"
                                    <?= $questScript && $questScript->repSiExpertVenu == 'oui' ? '' : 'hidden' ?>>
                                    <?php 
                                        $consignes = '';
                                        $paragraph = '<strong>Question <span name="numQuestionScript"></span>-c :</strong>
                                                    <p class="text-justify">Est-ce que votre assurance vous a déjà proposé une indemnisation pour couvrir les dommages matériels que vous avez subis ?</p>';
                                        include dirname(__FILE__) . '/blocs/questionContent.php';
                                        ?>
                                    <?php
                                        $name = 'repSiIndemProp';
                                        $options = [
                                            [
                                                'onclick' => "showSousQuestion('4-2-1-2',true);",
                                                'btn_class' => 'success',
                                                'value' => 'oui',
                                                'label' => 'Oui',
                                                'id' => 'respOui'
                                            ],
                                            [
                                                'onclick' => "showSousQuestion('4-2-1-2',false);",
                                                'btn_class' => 'danger',
                                                'value' => 'non',
                                                'label' => 'Non',
                                                'id' => 'respNon'
                                            ]
                                        ];
                                        include dirname(__FILE__) . '/blocs/responseOptions.php';
                                        ?>
                                    <!-- Si oui indemnisation -->
                                    <div id="sous-question-4-2-1-2"
                                        <?= $questScript && $questScript->repSiIndemProp == 'oui' ? '' : 'hidden' ?>>
                                        <?php 
                                            $consignes = '';
                                            $paragraph = '<strong>Question <span name="numQuestionScript"></span>-d :</strong>
                                                        <p class="text-justify">Avez-vous perçu l\'indemnité ?</p>';
                                            include dirname(__FILE__) . '/blocs/questionContent.php';
                                            ?>
                                                                                    <?php
                                            $name = 'indemnisationRecu';
                                            $options = [
                                                [
                                                    'onclick' => "",
                                                    'btn_class' => 'success',
                                                    'value' => 'oui',
                                                    'label' => 'Oui',
                                                    'id' => 'respOui'
                                                ],
                                                [
                                                    'onclick' => "",
                                                    'btn_class' => 'danger',
                                                    'value' => 'non',
                                                    'label' => 'Non',
                                                    'id' => 'respNon'
                                                ]
                                            ];
                                            include dirname(__FILE__) . '/blocs/responseOptions.php';
                                            ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Si Non expert mandaté -->
                            <div id="sous-question-4-2-2"
                                <?= $questScript && $questScript->repSiMandatExpert == 'non' ? '' : 'hidden' ?>>
                                <?php 
                                    $consignes = '';
                                    $paragraph = '<strong>Question <span name="numQuestionScript"></span>-b :</strong>
                                                <p class="text-justify">D\'accord, nous allons pouvoir rapidement vous accompagner sur ce point afin de préparer au mieux votre dossier et défendre efficacement vos intérêts. Notre démarche consistera à contacter votre assureur pour vérifier l\'état d\'avancement de votre dossier, et si nécessaire, assurer votre représentation en cas d\'expertise diligentée par votre compagnie.</p>';
                                    include dirname(__FILE__) . '/blocs/questionContent.php';
                                    ?>
                            </div>
                        </div>
                    </div>

                    <!-- SIGNATURE DELEGATION -->
                    <!-- Etape 9 : QUESTION DELEGATION-->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify">Si vous souhaitez que nous intervenions sur votre dossier, nous allons valider ensemble une délégation qui va nous permettre :<br>
                                        1- d\'intervenir pour vous auprès de votre assurance,<br>
                                        2- de vous faire bénéficier de toute notre expertise (défense de vos droits)<br>
                                        3- de faire effectuer vos travaux par nos professionnels qualifiés.<br>
                                        Vous aurez ensuite un délai de 14 jours pour vous rétracter (nous tenons à intervenir dans la confiance mutuelle, c\'est pour cela que nous avons souhaité doubler le délai légal de rétractation de 7 jours).</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <?php
                            $name = 'siSignDeleg';
                            $options = [
                                [
                                    'onclick' => "",
                                    'btn_class' => 'success',
                                    'value' => 'oui',
                                    'label' => 'Oui'
                                ],
                                [
                                    'onclick' => "",
                                    'btn_class' => 'warning',
                                    'value' => 'plusTard',
                                    'label' => 'Plus Tard'
                                ],
                                [
                                    'onclick' => "",
                                    'btn_class' => 'danger',
                                    'value' => 'non',
                                    'label' => 'Non'
                                ]
                            ];
                            include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                    </div>

                    <!-- SI SIGNATURE = OUI -->
                    <!-- Etape 10 : DELEGATION 1 -->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify">Merci de nous confirmer ces informations</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="row col-md-12">
                                    <div class="form-group col-md-4">
                                        <label for="">Prénom <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="prenomSignataire"
                                            name="prenomSignataire"
                                            value="<?= $gerant ? $gerant->prenom : ($questScript ? $questScript->prenomSignataire : "") ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Nom <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="nomSignataire" name="nomSignataire"
                                            value="<?= $gerant ? $gerant->nom : ($questScript ? $questScript->nomSignataire : "") ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Date Naissance <small class="text-danger">*</small>
                                        </label>
                                        <input class="form-control" type="date" name="dateNaissanceSignataire"
                                            max="<?= date('Y-m-d', strtotime('18 years ago')) ?>" id="dateNaissance"
                                            value="<?= $gerant ? $gerant->dateNaissance : ($questScript ? $questScript->dateNaissanceSignataire : "") ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 11 : DELEGATION 2 : Adresse -->
                    <div class="step">
                            <?php 
                                $consignes = '';
                                $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                            <p class="text-justify">Veuillez nous confirmez l\'adresse du sinistre</p>';
                                include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="row col-md-12 mt-2">
                                    <div class="col-md-4">
                                        <div>
                                            <label for="">Adresse <small class="text-danger">*</small></label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="text" name="adresse" id="adresseImm"
                                                value="<?= $contact->adresse ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="">Code Postal <small class="text-danger">*</small></label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="text" name="cp" id="cP"
                                                value="<?= $cntact->codePostal ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="">Ville <small class="text-danger">*</small></label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="text" name="ville" id="ville"
                                                value="<?= $contact->ville ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <div class="col-md-3">
                                        <div>
                                            <label for="">Etage <small class="text-danger">*</small></label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="text" name="etage" id="etage"
                                                value="<?= $questScript ? $questScript->etage : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div>
                                            <label for="">Porte <small class="text-danger">*</small></label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="text" name="porte" id="porte"
                                                value="<?= $questScript ? $questScript->porte : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div>
                                            <label for="">N° Lot</label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="text" name="lot" id="lot"
                                                value="<?= $questScript ? $questScript->lot : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div>
                                            <label for="">Bâtiment</label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="text" name="batiment" id="batiment"
                                                value="<?= $questScript ? $questScript->batiment : "" ?>">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 12 : DELEGATION 3 -->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify">Veuillez renseigner le nom de la compagnie d\'assurance</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <div class="response-options">
                            <div class="options-container">
                                <div class="col-md-12">
                                    <div>
                                        <label for="">Nom Compagnie <small class="text-danger">*</small></label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input readonly type="text" name="nomCieAssurance" id="nomCie"
                                                class="form-control"
                                                value="<?= isset($cie) && $cie ? $cie->name  : ($questScript ? $questScript->nomCieAssurance : "") ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <a type="button" rel="tooltip" id="btnAddCie"
                                                title="Ajouter ou Modifier la compagnie d'assurance"
                                                onclick="showModalCie('add')" class="btn btn-sm btn-secondary ">
                                                Ajouter/Modifier la Compagnie <i id="iconeAddCie" class="fa fa-plus"
                                                    style="color: #ffffff"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 13 : DELEGATION 4 -->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify">Veuillez renseigner les informations du contrat</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="row col-md-12 mt-2">
                                    <div class="col-md-4">
                                        <div>
                                            <label for="">N° Police Assurance (N° Contrat)
                                                <small class="text-danger">*</small></label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="text" name="numPolice" id="numPolice"
                                                value="<?= ($questScript ? $questScript->numPolice : "") ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for=""> Date Début Contrat <small
                                                    class="text-danger">*</small></label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="date" max="<?= date(" Y-m-d") ?>"
                                                name="dateDebutContrat" id="dateDebutContrat" value="
                            <?= "" ?>" onchange="onChangeDateDebutContrat()">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="">Date Fin Contrat <small class="text-danger">*</small></label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="date" name="dateFinContrat"
                                                id="dateFinContrat" value="<?= "" ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 14 : DELEGATION 5 - Envoi Code -->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify">Merci de nous confirmer votre adresse mail et numéro de téléphone. Vous recevrez un code de 6 chiffres par SMS sur ce numéro.</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="row col-md-12 mt-2">
                                    <div class="col-md-6 mt-2">
                                        <div>
                                            <label for="">Email <small class="text-danger">*</small>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="text" name="emailSign" id="emailSign" class="form-control"
                                                value="<?= $gerant ? $gerant->email : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div>
                                            <label for="">Téléphone <small class="text-danger">*</small>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="text" name="telSign" id="telSign" class="form-control"
                                                value="<?= $gerant ? $gerant->tel : "" ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 15 : DELEGATION 6 - Confirm Code -->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify">Merci de me communiquer le code à 6 chiffres que vous avez reçu</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <div class="response-options">
                            <div class="options-container">
                                <div class="row">
                                    <input maxlength="6" style="font-size: 50px;" type="text" name="codeSign"
                                        id="codeSign" class="form-control" value="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SI SIGNATURE = PLUS TARD -->
                    <!-- Etape 16 : DELEGATION 1 - Demander raison hesitation -->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify">Très bien, je comprends parfaitement. Pour mieux vous accompagner, pourriez-vous simplement me préciser la raison principale pour laquelle vous souhaitez signer un peu plus tard</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <div class="response-options">
                            <div class="options-container col-md-11">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input onclick="onClickChoixSignaturePT()" value="prendreConnaissance"
                                                id="prendreConnaissance" name="raisonRefusSignature" type="radio"
                                                <?= checked('raisonRefusSignature', 'prendreConnaissance', $questScript, 'checked') ?> />
                                            <label for="prendreConnaissance"> a- Je
                                                souhaite
                                                prendre connaissance tranquillement du document avant de signer</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input onclick="onClickChoixSignaturePT()" id="signatureComplique"
                                                value="signatureComplique" name="raisonRefusSignature" type="radio"
                                                <?= checked('raisonRefusSignature', 'signatureComplique', $questScript, 'checked') ?> />
                                            <label for="signatureComplique"> b- Je n’ai pas l’habitude des signatures
                                                électroniques, cela me paraît compliqué.</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input onclick="onClickChoixSignaturePT()" id="documentManquant"
                                                value="documentManquant" name="raisonRefusSignature" type="radio"
                                                <?= checked('raisonRefusSignature', 'documentManquant', $questScript, 'checked') ?> />
                                            <label for="documentManquant">c- Je n’ai
                                                pas
                                                tous
                                                les documents ou toutes les informations sur moi.</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input onclick="onClickChoixSignaturePT()" value="prefereDemander"
                                                id="prefereDemander" name="raisonRefusSignature" type="radio"
                                                <?= checked('raisonRefusSignature', 'prefereDemander', $questScript, 'checked') ?> />
                                            <label for="prefereDemander"> d- Je préfère
                                                en
                                                parler d'abord avec un proche ou un associé</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Étape 17 cloture Script -->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>FIN DU SCRIPT :</strong>
                                        <p id="textCloture">Je vous remercie et vous souhaite une bonne fin de journée.</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <div class="response-options" id="reponseDoc">
                            <div class="options-container">
                                <button
                                    onclick="selectRadio(this);showSousQuestion('17-1',true);showSousQuestion('17-2',false);"
                                    type="button" data-value="Oui" class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio" class="btn-check" name="siEnvoiDoc"
                                            <?= checked('siEnvoiDoc', 'oui', $questScript, 'checked') ?> value="oui" />
                                    </div>
                                    Oui
                                </button>
                                <button
                                    onclick="selectRadio(this);showSousQuestion('17-1',false);showSousQuestion('17-2',true);"
                                    type="button" data-value="Oui" class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="siEnvoiDoc" value="non"
                                            <?= checked('siEnvoiDoc', 'non', $questScript, 'checked') ?> />
                                    </div>
                                    Non
                                </button>
                            </div>
                        </div>

                        <!-- Si Oui Envoi Documentation -->
                        <div id="sous-question-17-1" hidden>
                            <div class="question-box ">
                                <div class="agent-icon">
                                    <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                                </div>
                                <div class="question-content col-md-11">
                                    <div class="col-md-12 mb-3" id="divEnvoiDoc" hidden>
                                        <!-- INFOS MAIL -->
                                        <div class="row col-md-12">
                                            <div class="form-group col-md-4">
                                                <label for="">Civilité</label>
                                                <select name="civiliteGerant" ref="civiliteGerant" id=""
                                                    class="form-control">
                                                    <option value="">....</option>
                                                    <option
                                                        <?= $gerant && $gerant->civilite == "Monsieur" ? 'selected' : '' ?>
                                                        value="Monsieur">Monsieur</option>
                                                    <option
                                                        <?= $gerant && $gerant->civilite == "Madame" ? 'selected' : '' ?>
                                                        value="Madame">Madame</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="">Prénom</label>
                                                <input type="text" class="form-control" name="prenomGerant"
                                                    ref="prenomGerant" value="<?= $gerant ? $gerant->prenom : '' ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="">Nom</label>
                                                <input type="text" class="form-control" name="nomGerant" ref="nomGerant"
                                                    value="<?= $gerant ? $gerant->nom : '' ?>">
                                            </div>
                                        </div>

                                        <div class="row col-md-12">
                                            <div class="form-group col-md-4">
                                                <label for="">Email</label>
                                                <input type="email" class="form-control" name="emailGerant"
                                                    ref="emailGerant" value="<?= $gerant ? $gerant->email : '' ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="">Téléphone</label>
                                                <input type="text" class="form-control" name="telGerant" ref="telGerant"
                                                    value="<?= $gerant ? $gerant->tel : '' ?>">
                                            </div>
                                            <div class="form-group col-md-4" hidden>
                                                <label for="">Poste</label>
                                                <select readonly name="posteGerant" ref="posteGerant" id=""
                                                    class="form-control">
                                                    <option value="responsable">Responsable</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="question-text">
                                        <p class="text-justify">Parfait, je vous adresse immédiatement notre
                                            documentation par mail. N'hésitez pas à nous recontacter en cas de besoin.
                                            Excellente journée ! <br>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="sous-question-17-2" hidden>
                            <?php 
                                $consignes = '';
                                $paragraph = '<p class="text-justify">Très bien, je prends note. Nous restons disponibles si jamais vous avez besoin d\'assistance à l\'avenir. Je vous souhaite une agréable journée !<br></p>';
                                include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                        </div>
                    </div>

                    <!-- PRISE DE RDV RT -->
                    <!-- Etape 18 : RT 1 -->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify">Nous allons organiser un rendez-vous avec notre expert interne pour effectuer un relevé technique directement sur place. Il prendra les mesures et établira un rapport détaillé à transmettre à votre assureur, afin de faciliter la prise en charge de votre dossier. Quand seriez-vous disponible pour ce rendez-vous ?</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this)" type="button" data-value="Oui"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('accordRVRT', 'oui', $questScript, 'checked') ?>
                                            class="btn-check" name="accordRVRT" id="respOui" value="oui" /></div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this)" type="button" data-value="Oui"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check"
                                            <?= checked('accordRVRT', 'non', $questScript, 'checked') ?>
                                            name="accordRVRT" id="respNon" value="non" />
                                    </div>
                                    Non
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 19 : PRISE DE RDV RT-->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify">Je vous propose la date suivante :</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="col-md-12">
                                    <div class="font-weight-bold">
                                        <span class="text-center text-danger">1. Veuillez selectionner la
                                            plage
                                            de
                                            disponibilité pour le sinistré</span>
                                    </div>
                                    <div class="row mt-2 mb-2 ml-2">
                                        <div class="col-md-12 row">
                                            <div class="col-md-4 row">
                                                <div class="col-md-3" style="background-color: #d3ff78;">

                                                </div>
                                                <div class="col-md-9">
                                                    <span>
                                                        <?= $rv ? "Même Date & Même Heure" : "RV à moins de 30min" ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 row">
                                                <div class="col-md-3" style="background-color: lightblue;">

                                                </div>
                                                <div class="col-md-9">
                                                    <span>
                                                        <?= $rv ? "Même Date mais Heure différente" : "Disponible Mi-Journée" ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 row">
                                                <div class="col-md-3" style="background-color: #FF4C4C;">

                                                </div>
                                                <div class="col-md-9">
                                                    <span>Expert Sans RDV</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2" id="divTabDisponibilite">

                                    </div>
                                    <div>
                                        <div
                                            class="offset-2 col-md-8 pagination pagination-sm row text-center mb-3 mt-1">
                                            <div class="pull-left page-item col-md-6 p-0 m-0">
                                                <div id="btnPrecedentRDV">
                                                    <a type="button" class="text-center btn"
                                                        style="background-color: grey;color:white"
                                                        onclick="onClickPrecedentRDV()">Dispos Prec. << </a>
                                                </div>
                                            </div>
                                            <div id="btnSuivantRDV" class="pull-right page-item col-md-6 p-0 m-0"><a
                                                    type="button" class="text-center btn"
                                                    style="background-color: grey;color:white"
                                                    onclick="onClickSuivantRDV()">>>
                                                    Dispos Suiv.</a></div>
                                        </div>
                                    </div>
                                    <div class="row mt-2" id="divTabHoraire">


                                    </div>
                                    <div class=" row mt-5 text-center">
                                        <h4 class="text-center font-weight-bold" id="INFO_RDV"></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Étape 20 : Plus de précisions -->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify">Bien sûr, je vous explique rapidement : SOS Sinistre est spécialisée dans l\'accompagnement et la gestion des sinistres immobiliers comme les dégâts des eaux, les incendies ou les bris de glace, de manière totalement gratuite pour le sinistré. Nous intervenons de la déclaration à la réparation, sans avance de frais de votre part, en facilitant toutes les démarches administratives avec votre assurance et en faisant effectuer les travaux par des professionnels. Êtes-vous intéressé ?</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <?php
                            $name = 'confirmResponsable';
                            $options = [
                                [
                                    'onclick' => "",
                                    'btn_class' => 'success',
                                    'value' => 'oui',
                                    'label' => 'Oui'
                                ],
                                [
                                    'onclick' => "",
                                    'btn_class' => 'danger',
                                    'value' => 'non',
                                    'label' => 'Non'
                                ]
                            ];
                            include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                    </div>

                    <!-- Étape 21 : Non pas responsable -->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify">J\'ai une information importante concernant la gestion des sinistres immobiliers qui pourrait vous intéresser directement.</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <?php
                            $name = 'dispoResp';
                            $options = [
                                [
                                    'onclick' => "",
                                    'btn_class' => 'success',
                                    'value' => 'dispo',
                                    'label' => 'Disponible'
                                ],
                                [
                                    'onclick' => "",
                                    'btn_class' => 'danger',
                                    'value' => 'refus',
                                    'label' => 'Refus Transfert'
                                ]
                            ];
                            include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                    </div>

                    <!-- Etape 22  : SI Sinistre -->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify">Très bien, puisque le responsable n\'est pas disponible pour le moment, nous allons donc poursuivre ensemble. Justement, pourriez-vous me dire si votre établissement subit actuellement un sinistre ? Est-ce un sujet dont vous avez connaissance ou dont vous pourriez me parler directement ?</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio" class="btn-check"
                                            name="reponse_concerne2" value="oui" ref="reponse_concerne2"
                                            <?= checked('reponse_concerne2', 'oui', $questScript, 'checked') ?> /></div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="reponse_concerne2"
                                            ref="reponse_concerne2"
                                            <?= checked('reponse_concerne2', 'non', $questScript, 'checked') ?>
                                            value="non" />
                                    </div>
                                    Non
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 23 Si Responsable Sinistre -->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify">Comme je ne pourrai pas être mis en relation avec le responsable, savez-vous s\'il y a actuellement un sinistre en cours dans votre établissement ?</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <?php
                            $name = 'siSinistreEnCours';
                            $options = [
                                [
                                    'onclick' => "",
                                    'btn_class' => 'success',
                                    'value' => 'oui',
                                    'label' => 'Oui'
                                ],
                                [
                                    'onclick' => "",
                                    'btn_class' => 'warning',
                                    'value' => 'je ne sais pas',
                                    'label' => 'Je ne sais pas'
                                ],
                                [
                                    'onclick' => "",
                                    'btn_class' => 'danger',
                                    'value' => 'non',
                                    'label' => 'Non'
                                ]
                            ];
                            include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                    </div>

                    <!-- Etape 24: Si Coordonnées Responsable -->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify">Je comprends tout à fait. Pourriez-vous me transmettre les coordonnées de la personne habilitée afin de fixer ce rendez-vous à un moment qui lui conviendra ?</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <?php
                            $name = 'siRvTelResponsable';
                            $options = [
                                [
                                    'onclick' => "",
                                    'btn_class' => 'success',
                                    'value' => 'oui',
                                    'label' => 'Oui'
                                ],
                                [
                                    'onclick' => "",
                                    'btn_class' => 'warning',
                                    'value' => 'refusAvecDoc',
                                    'label' => 'Refus, avec Envoi Documentation'
                                ],
                                [
                                    'onclick' => "",
                                    'btn_class' => 'danger',
                                    'value' => 'refusSansDoc',
                                    'label' => 'Refus, sans Envoi Documentation'
                                ]
                            ];
                            include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                    </div>

                    <!-- Etape 25 Form Interlocuteur -->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify">Avant de poursuivre, je vais simplement noter vos coordonnées afin que nous puissions rester facilement en contact et vous tenir informé(e) de l\'évolution de votre dossier. Pourriez-vous me préciser votre nom, prénom, numéro de téléphone direct et adresse email, s\'il vous plaît ?</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <div class="card-body col-md-11" style="margin-left: 95px; margin-bottom: 10px;">
                            <input type="hidden" class="form-control" name="idInterlocuteur" value="0">
                            <input type="hidden" class="form-control" name="idCompanyInterlocuteur"
                                value="<?= $company ? $company->idCompany : '0' ?>">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="">Civilité</label>
                                    <select name="civiliteInterlocuteur" id="" class="form-control">
                                        <option value="">....</option>
                                        <option value="Monsieur">Monsieur</option>
                                        <option value="Madame">Madame</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Prénom</label>
                                    <input type="text" class="form-control" name="prenomInterlocuteur" value="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Nom</label>
                                    <input type="text" class="form-control" name="nomInterlocuteur" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="emailInterlocuteur" value="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Téléphone</label>
                                    <input type="text" class="form-control" name="telInterlocuteur" value="">
                                </div>
                                <!-- <div class="form-group col-md-4">
                                    <label for="">Poste</label>
                                    <select name="posteInterlocuteur" id="" class="form-control">
                                        <option value="">...</option>
                                        <option value="gérant">Gérant</option>
                                        <option value="secretaire">Secretaire</option>
                                        <option value="Directeur Technique">Directeur Technique</option>
                                    </select>
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <!-- Etape 26 Demande Si interlocuteur habile  -->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify">Afin que nous puissions intervenir efficacement et gratuitement dans la gestion complète de votre sinistre auprès de votre assurance, nous allons devoir valider ensemble une délégation. Cette délégation nous permet simplement de vous représenter officiellement auprès de votre assureur pour défendre vos intérêts, sans frais et sans aucun engagement financier de votre part.<br>
                                        Êtes-vous personnellement habilité(e) à valider cette délégation ?</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <?php
                            $name = 'reponse_sihabile_signature';
                            $options = [
                                [
                                    'onclick' => "",
                                    'btn_class' => 'success',
                                    'value' => 'oui',
                                    'label' => 'Oui'
                                ],
                                [
                                    'onclick' => "",
                                    'btn_class' => 'warning',
                                    'value' => 'refus',
                                    'label' => 'Habilité mais Refus'
                                ],
                                [
                                    'onclick' => "",
                                    'btn_class' => 'danger',
                                    'value' => 'non',
                                    'label' => 'Non'
                                ]
                            ];
                            include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                    </div>

                    <!-- Etape 27 PROGRAMMER RDV PERSO -->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify" id="textPropositionHesitationSignature">Demande des raisons précises</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <button onclick="selectRadio(this);showSousQuestion('16-1',true);" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio" name="siRdvPerso" value="oui"
                                            <?= checked('siRdvPerso', 'oui', $questScript, 'checked') ?>
                                            class="btn-check">
                                    </div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this);showSousQuestion('16-1',false);" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="siRdvPerso" value="non" class="btn-check"
                                            <?= checked('siRdvPerso', 'non', $questScript, 'checked') ?> />
                                    </div>
                                    Non
                                </button>

                                <!-- SI OUI RDV PERSO -->
                                <div class="row col-md-12 ml-0" id="sous-question-16-1" hidden>
                                    PRENDRE COORDONNES UN RDV PERSO TELEPHONIQUE POUR REPRENDRE LA CONVERSATION PLUS
                                    TARD
                                    <div class="col-md-12 mb-3">
                                        <!-- INFOS MAIL -->
                                        <div class="row col-md-12">
                                            <div class="form-group col-md-4">
                                                <label for="">Civilité</label>
                                                <select ref="civiliteGerant" name="civiliteGerant" id=""
                                                    class="form-control">
                                                    <option value="">....</option>
                                                    <option
                                                        <?= $gerant && $gerant->civilite == "Monsieur" ? 'selected' : '' ?>
                                                        value="Monsieur">Monsieur</option>
                                                    <option
                                                        <?= $gerant && $gerant->civilite == "Madame" ? 'selected' : '' ?>
                                                        value="Madame">Madame</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="">Prénom</label>
                                                <input type="text" class="form-control" name="prenomGerant"
                                                    ref="prenomGerant" value="<?= $gerant ? $gerant->prenom : '' ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="">Nom</label>
                                                <input type="text" class="form-control" name="nomGerant" ref="nomGerant"
                                                    value="<?= $gerant ? $gerant->nom : '' ?>">
                                            </div>
                                        </div>

                                        <div class="row col-md-12">
                                            <div class="form-group col-md-4">
                                                <label for="">Email</label>
                                                <input type="email" class="form-control" name="emailGerant"
                                                    ref="emailGerant" value="<?= $gerant ? $gerant->email : '' ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="">Téléphone</label>
                                                <input type="text" class="form-control" name="telGerant" ref="telGerant"
                                                    value="<?= $gerant ? $gerant->tel : '' ?>">
                                            </div>
                                            <!-- <div class="form-group col-md-4">
                                                <label for="">Poste</label>
                                                <select readonly name="posteGerant" ref="posteGerant" id=""
                                                    class="form-control">
                                                    <option value="responsable">Responsable</option>
                                                </select>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Etape 28: Si Coordonnées Responsable -->
                    <div class="step">
                        <?php 
                            $consignes = '';
                            $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify" id="textCoordonneesResponsable">Très bien, je vais noter les coordonnées complètes de votre responsable pour fixer ce rendez-vous. Pouvez-vous me donner son nom, prénom, sa fonction exacte dans l\'établissement, son numéro de téléphone direct ainsi que son adresse email, s\'il vous plaît ?</p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="row mt-2">
                                    <div class="form-group col-md-4">
                                        <label for="">Civilité</label>
                                        <select name="civiliteGerant" id="" class="form-control">
                                            <option value="">....</option>
                                            <option <?= $gerant && $gerant->civilite == "Monsieur" ? 'selected' : '' ?>
                                                value="Monsieur">Monsieur</option>
                                            <option <?= $gerant && $gerant->civilite == "Madame" ? 'selected' : '' ?>
                                                value="Madame">Madame</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Prénom</label>
                                        <input type="text" class="form-control" name="prenomGerant"
                                            value="<?= $gerant ? $gerant->prenom : '' ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Nom</label>
                                        <input type="text" class="form-control" name="nomGerant"
                                            value="<?= $gerant ? $gerant->nom : '' ?>">
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="form-group col-md-4">
                                        <label for="">Email</label>
                                        <input type="email" class="form-control" name="emailGerant"
                                            value="<?= $gerant ? $gerant->email : '' ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Téléphone</label>
                                        <input type="text" class="form-control" name="telGerant"
                                            value="<?= $gerant ? $gerant->tel : '' ?>">
                                    </div>
                                    <!-- <div class="form-group col-md-4">
                                        <label for="">Poste</label>
                                        <select readonly name="posteGerant" id="" class="form-control">
                                            <option value="Responsable">Responsable</option>
                                            <option value="Gérant">Gérant</option>
                                            <option value="Dirigeant">Dirigeant</option>
                                        </select>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                PRISE DE RDV PERSO
                            </div>
                        </div>
                    </div>
                    <!-- Navigation -->
                    <!-- <div class="buttons">
                        <button id="prevBtn" type="button" class="btn-prev hidden" onclick="goBackScript()">⬅
                            Précédent</button>
                        <label for="">Page <span id="indexPage" class="font-weight-bold"></span></label>
                        <button id="nextBtn" type="button" class="btn-next" onclick="goNext()">Suivant ➡</button>
                        <button id="finishBtn" type="button" class="btn-finish hidden" onclick="finish()">✅
                            Terminer</button>
                    </div> -->
                    <?php $section = ''; include dirname(__FILE__) . '/blocs/navigationBtns.php'; ?>

                </form>

            </div>