<?php
class IWCalendar
{

    private $mesArray;
    private $startWeek = 'Seg';
    private $week;

    public function __construct($nMonth = 1)
    {

        $this->mesArray = [
            ['', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
        ];

        $this->week = [
            'Dom' => [
                'BR' => ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                'EN' => ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']],
            'Seg' => [
                'BR' => ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab', 'Dom'],
                'EN' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']]];
    }

    public function createMonth($month = null, $year = null, $startWeek = null)
    {
        $month     = !$month ? date('m') : $month;
        $year      = !$year ? date('Y') : $year;
        $startWeek = !$startWeek ? $this->startWeek : $startWeek;
        $dt        = new DateTime($year . '-' . $month . '-01');
        $dayWeek   = $dt->format('D');
        $iWeek = array_search($dayWeek, $this->week[$startWeek]['EN']);
        $flag  = false;

        for ($c = 0; $c <= 6; $c++) {
            echo substr($this->week[$startWeek]['BR'][$c], 0, 3);
        }
        echo PHP_EOL;
        $mesArray = [];
        for ($l = 0; $l <= 5; $l++) {
            for ($c = 0; $c <= 6; $c++) {
                if ($c == $iWeek and $l == 0) {
                    $flag = true;
                }

                if (!$flag) {
                    echo '__ ';
                    $mesArray[$year][$month][$l][$c] = '';
                } else {
                    echo $dt->format('d') . ' ';
                    $mesArray[$year][$month][$l][$c] = $dt->format('d');
                    $dt->add(new DateInterval("P1D"));
                }

                if ($dt->format('m') != $month) {
                    $flag = false;
                }

            }
            echo PHP_EOL;
        }

        return $mesArray;
    }
}
