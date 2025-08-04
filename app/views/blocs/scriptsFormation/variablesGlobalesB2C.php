<?php
/**
 * Variables globales pour campagne Formation B2C
 */
?>
<script>
// Variables de navigation
let currentStep = 0;
let pageIndex = 1;
let numQuestionScript = 1;
let history = [];
let dateRDV = "";
let heureDebutRDV = "";
let heureFinRDV = "";
let signature = null;
let siInterlocuteur = false;
let opCree = null;

// Variables RDV 1
let rdv1Exst = true;
let divRDV1 = '';
let rdv1Position1 = 0;
let hidePlaceRdv1 = true;
let hidePlaceRdvbis = true;

// Variables RDV 2
let hidePlaceRdv2 = true;
let hidePlaceRdv2bis = true;

// Variables pour la gestion géographique
let regionsChoosed = [];
let departementChoosed = [];

// Variables pour l'assistant technique
let numPageTE = 0;
let nbPageTE = 4;

// Variables pour l'assistant signature
let numPageSign = 0;
let nbPageSign = 7;

// Variables pour l'assistant RV
let numPageRV = 0;
let nbPageRV = 4;

// Variables RDV
let tab = [];
let taille = 0;

// Éléments DOM
const steps = document.querySelectorAll('.form-step');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const finishBtn = document.getElementById('finishBtn');
const indexPage = document.getElementById('indexPage');
const refs = document.querySelectorAll('[ref]');

// Initialisation des numéros de questions
$(`#numQuestionScript0`).text(1);
</script>
