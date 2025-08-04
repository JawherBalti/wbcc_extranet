<div class="script-container" style="margin-top:15px; padding:10px; border: 1px solid #36B9CC"
                    id="divBodyAccueil">
                    <div class="mb-5 mt-5">
                        <div class="question-box mb-5 mt-5">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <p class="text-justify">Bonjour, je suis <b>
                                            <?= $connectedUser->fullName   ?>
                                        </b> de la
                                        société
                                        SOS Sinistre, spécialisée dans la gestion des sinistres immobiliers. <br> J'ai
                                        une
                                        information importante à porter à votre connaissance. <br>Est-ce que je suis
                                        bien
                                        avec
                                        la société <b>
                                            <?= $company->name ?>
                                        </b> ?</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>