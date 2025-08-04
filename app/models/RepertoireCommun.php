<?php

class RepertoireCommun extends Model
{
    public function getRepertoire($periode, $dateOne, $dateDebut, $dateFin)
    {
        $sql = "SELECT * FROM wbcc_repertoire_commun WHERE isDeleted = 0";
        // Filter by time period
        switch ($periode) {
            case 'today':
                $sql .= " AND DATE(createDate) = CURDATE()";
                break;

            case 'semaine':
                $sql .= " AND YEARWEEK(createDate, 1) = YEARWEEK(CURDATE(), 1)";
                break;

            case 'mois':
                $sql .= " AND YEAR(createDate) = YEAR(CURDATE()) AND MONTH(createDate) = MONTH(CURDATE())";
                break;

            case 'annee':
                $sql .= " AND YEAR(createDate) = YEAR(CURDATE())";
                break;

            case 'trimestre':
                $month = (int)date('m');
                $quarter = ceil($month / 3);
                $startMonth = ($quarter - 1) * 3 + 1;
                $endMonth = $quarter * 3;
                $sql .= " AND MONTH(createDate) BETWEEN $startMonth AND $endMonth AND YEAR(createDate) = YEAR(CURDATE())";
                break;

            case 'semestre':
                $month = (int)date('m');
                if ($month <= 6) {
                    $sql .= " AND MONTH(createDate) BETWEEN 1 AND 6 AND YEAR(createDate) = YEAR(CURDATE())";
                } else {
                    $sql .= " AND MONTH(createDate) BETWEEN 7 AND 12 AND YEAR(createDate) = YEAR(CURDATE())";
                }
                break;

            case '1': // 'À la date du'
                if ($dateOne) {
                    $dateOneFormatted = DateTime::createFromFormat('d-m-Y', $dateOne);
                    if ($dateOneFormatted) {
                        $formattedDate = $dateOneFormatted->format('Y-m-d');
                        $sql .= " AND DATE(createDate) = '$formattedDate'";
                    } else {
                        echo json_encode(['error' => 'Invalid date format for dateOne']);
                        exit;
                    }
                }
                break;

            case '2': // 'Personnaliser'
                if ($dateDebut && $dateFin) {
                    $dateDebutFormatted = DateTime::createFromFormat('d-m-Y', $dateDebut);
                    $dateFinFormatted = DateTime::createFromFormat('d-m-Y', $dateFin);
                    if ($dateDebutFormatted && $dateFinFormatted) {
                        $formattedDateDebut = $dateDebutFormatted->format('Y-m-d');
                        $formattedDateFin = $dateFinFormatted->format('Y-m-d');
                        $sql .= " AND DATE(createDate) BETWEEN '$formattedDateDebut' AND '$formattedDateFin'";
                    } else {
                        echo json_encode(['error' => 'Invalid date format for dateDebut or dateFin']);
                        exit;
                    }
                }
                break;

            default:
                // No date filter applied
                break;
        }

        $sql .= " ORDER BY createDate";
        $this->db->query($sql);
        return $this->db->resultSet();
    }
}
