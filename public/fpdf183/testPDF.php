<?php
// define('FPDF_FONTPATH',"./font/");
// require('makefont/makefont.php');

// MakeFont('C:\\Windows\\Fonts\\comic.ttf','cp1252');
require('fpdf.php');


class PDF extends FPDF
{

    // En-tête
    function Header()
    {
        if ($this->PageNo() == 1) {
            $this->SetFont('Times', 'B', 20);
            $this->SetFillColor(192, 0, 0);
            $this->Cell(0, 0, 'CURRICULUM VITAE', 0, 0, 'C', false, '');
        }
    }

    // Pied de page
    function Footer()
    {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-8);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, $this->PageNo() . '/{nb}', 0, 0, 'C');
        // Début en police normale

        $this->SetY(-12);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Fait le ' . date('d/m/Y'), 0, 0, 'C');
    }
}

$pdf = new PDF();

//Numéro de page
$pdf->AliasNbPages();
// Page Tableau rapport de recherche de fuite
$pdf->AddPage();
$pdf->SetY(15 - $pdf->GetPageHeight());

$pdf->Ln(6);
$pdf->SetFont('Times', 'BU', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->Write(6, iconv('UTF-8', 'windows-1252', "Profil"));
$pdf->Ln(6);

$pdf->SetFont('Times', '', 12);

$pdf->MultiCell(0, 5, iconv('UTF-8', 'windows-1252', "Nous avons été mandatés par Relais Habitat pour effectuer une recherche de fuite en date du 07/05/2021 dans l’appartement/immeuble situé à l’adresse 127 rue Gabriel Péri 93200 Saint DENIS.
// Cette demande fait suite à un signalement à Relais habitat de XXXX le 07 mai 2021, notre technicien est intervenu pour déterminer la cause de cette fuite."));
// INFOS PERSO
$pdf->Ln(5);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(127, 127, 127);
$pdf->Cell(0, 8, 'DETAILS PERSONNELS', 1, 0, 'C', true);
$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(60, 6, iconv('UTF-8', 'windows-1252', "Civilité : "), 0, 'L');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(40, 6, "Mlle", 0);
$pdf->Ln(8);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(60, 6, "Nom Complet : ", 0, 'L');
$pdf->SetFont('Times', '', 12);
$pdf->MultiCell(0, 5, iconv('UTF-8', 'windows-1252', "Ndacke GUEYE"));
$pdf->Ln(4);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(60, 6, "Situation : ", 0, 'L');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(40, 6, iconv('UTF-8', 'windows-1252', "Célibataire"), 0);
$pdf->Ln(8);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(60, 6, "Date de Naissance : ", 0, 'L');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(40, 6, "06-03-2000", 0);
$pdf->Ln(8);

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(60, 6, "Lieu de Naissance : ", 0, 'L');
$pdf->SetFont('Times', '', 12);
$pdf->MultiCell(0, 5, iconv('UTF-8', 'windows-1252', "Dakar Pikine Société de la place Poste de santé unité 09"));
$pdf->Ln(4);

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(60, 6, "Adresse : ", 0, 'L');
$pdf->SetFont('Times', '', 12);
$pdf->MultiCell(0, 5, iconv('UTF-8', 'windows-1252', "Dakar Pikine Société de la place Poste de santé unité 09"));
$pdf->Ln(4);

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(60, 6, "Ville: ", 0, 'L');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(100, 6, "Dakar", 0);
$pdf->Ln(8);

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(60, 6, "Téléphone(s) : ", 0, 'L');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(150, 6, "+33140353569 / +2217745698745 / +1256987485", 0);
$pdf->Ln(8);


$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(60, 6, "Email(s) : ", 0, 'L');
$pdf->SetFont('Times', '', 12);
$pdf->MultiCell(0, 5, iconv('UTF-8', 'windows-1252', "wbcc020-test@wbcc.fr / test-test-test1459@example.com /wbcc020-test@wbcc.fr / test-test-test1459@example.com"));
$pdf->Ln(15);

// EXPERIENCES
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(127, 127, 127);
$pdf->Cell(0, 8, 'EXPERIENCES', 1, 0, 'C', true);
$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(75, 6, iconv('UTF-8', 'windows-1252', "Septembre 2020 - Décembre 2021"), 0, 'L');
$pdf->Cell(100, 6, iconv('UTF-8', 'windows-1252', "Titre Expérience"), 0);
$pdf->Ln();
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(75, 6, "", 0, 'L');
$pdf->SetFont('Times', 'I', 12);
$pdf->Cell(100, 6, iconv('UTF-8', 'windows-1252', "Nom entreprise"), 0);
$pdf->Ln(8);
$pdf->SetFont('Times', '', 12);
$pdf->Cell(75, 6, "", 0, 'L');
$pdf->MultiCell(0, 5, iconv('UTF-8', 'windows-1252', "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Laudantium dolor corrupti at facere doloribus itaque totam cum hic provident quasi, voluptatum optio perferendis quis quos, aperiam alias? Mollitia, repellendus inventore!"));
$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(75, 6, iconv('UTF-8', 'windows-1252', "Septembre 2020 - Décembre 2021"), 0, 'L');
$pdf->Cell(100, 6, "Titre Expérience", 0);
$pdf->Ln();
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(75, 6, "", 0, 'L');
$pdf->SetFont('Times', 'I', 12);
$pdf->Cell(100, 6, iconv('UTF-8', 'windows-1252', "Nom entreprise"), 0);
$pdf->Ln(8);
$pdf->SetFont('Times', '', 12);
$pdf->Cell(75, 6, "", 0, 'L');
$pdf->MultiCell(0, 5, iconv('UTF-8', 'windows-1252', "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Laudantium dolor corrupti at facere doloribus itaque totam cum hic provident quasi, voluptatum optio perferendis quis quos, aperiam alias? Mollitia, repellendus inventore!"));
$pdf->Ln(15);

// FORMATIONS
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(127, 127, 127);
$pdf->Cell(0, 8, 'FORMATIONS', 1, 0, 'C', true);
$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(75, 6, iconv('UTF-8', 'windows-1252', "Septembre 2020 - A nos jours"), 0, 'L');
$pdf->Cell(100, 6, "Titre Formation", 0);
$pdf->Ln();
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(75, 6, "", 0, 'L');
$pdf->SetFont('Times', 'I', 12);
$pdf->Cell(100, 6, iconv('UTF-8', 'windows-1252', "Ecole de formation"), 0);
$pdf->Ln();
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(75, 6, "", 0, 'L');
$pdf->SetFont('Times', 'BI', 12);
$pdf->Cell(100, 6, iconv('UTF-8', 'windows-1252', "Niveau de la formation"), 0);
$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(75, 6, "Septembre 2020 - A nos jours", 0, 'L');
$pdf->Cell(100, 6, "Titre Formation", 0);
$pdf->Ln();
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(75, 6, "", 0, 'L');
$pdf->SetFont('Times', 'I', 12);
$pdf->Cell(100, 6, "Ecole de formation", 0);
$pdf->Ln();
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(75, 6, "", 0, 'L');
$pdf->SetFont('Times', 'BI', 12);
$pdf->Cell(100, 6, "Niveau de la formation", 0);
$pdf->Ln(15);

// COMPETENCES
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(127, 127, 127);
$pdf->Cell(0, 8, 'COMPETENCES', 1, 0, 'C', true);
$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Times', 'B', 12);
$pdf->MultiCell(0, 5, iconv('UTF-8', 'windows-1252', "Nom de la compétence 1"));
$pdf->SetFont('Times', '', 12);
$pdf->MultiCell(0, 5, iconv('UTF-8', 'windows-1252', "Lorem, ipsum dolor sit amet consectetur adipisicing elit"));
$pdf->Ln();
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Times', 'B', 12);
$pdf->MultiCell(0, 5, "Nom de la compétence 2");
$pdf->SetFont('Times', '', 12);
$pdf->MultiCell(0, 5, "Lorem, ipsum dolor sit amet consectetur adipisicing elit");
$pdf->Ln(15);

// LANGUES
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(127, 127, 127);
$pdf->Cell(0, 8, 'LANGUES', 1, 0, 'C', true);
$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(100, 6, iconv('UTF-8', 'windows-1252', "Anglais"), 0, 'L');
$pdf->SetFont('Times', 'I', 12);
$pdf->Cell(75, 6, iconv('UTF-8', 'windows-1252', "Lu, écrit, parlé"), 0);
$pdf->Ln(8);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(100, 6, iconv('UTF-8', 'windows-1252', "Français"), 0, 'L');
$pdf->SetFont('Times', 'I', 12);
$pdf->Cell(75, 6, iconv('UTF-8', 'windows-1252', "Lu, écrit, parlé"), 0);
$pdf->Ln(15);


// DIVERS
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(127, 127, 127);
$pdf->Cell(0, 8, 'DIVERS', 1, 0, 'C', true);
$pdf->Ln(10);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(100, 6, "Permis", 0, 'L');
$pdf->SetFont('Times', 'BI', 12);
$pdf->Cell(75, 6, "B", 0);
$pdf->Ln(8);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(100, 6, iconv('UTF-8', 'windows-1252', "Année d'obtention Permis"), 0, 'L');
$pdf->SetFont('Times', 'BI', 12);
$pdf->Cell(75, 6, "2020", 0);

$pdf->Ln(8);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(100, 6, iconv('UTF-8', 'windows-1252', "Disponibilté"), 0, 'L');
$pdf->SetFont('Times', 'BI', 12);
$pdf->Cell(75, 6, iconv('UTF-8', 'windows-1252', "Immédiate"), 0);
$pdf->Ln(8);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(100, 6, iconv('UTF-8', 'windows-1252', "Durée préavis"), 0, 'L');
$pdf->SetFont('Times', 'BI', 12);
$pdf->Cell(75, 6, "2 mois", 0);
$pdf->Ln(8);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(100, 6, iconv('UTF-8', 'windows-1252', "Salaire souhaité"), 0, 'L');
$pdf->SetFont('Times', 'BI', 12);
$pdf->Cell(75, 6, iconv('UTF-8', 'windows-1252', "100.000 - 500.000 FCFA"), 0);
$pdf->Ln(15);


$pdf->Output();
