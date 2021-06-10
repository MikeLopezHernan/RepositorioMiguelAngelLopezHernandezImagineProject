<?php

namespace AppBundle\Twig;

class timePublicationExtension extends \Twig_Extension {
    
	public function getFilters() {
		return array(
			new \Twig_SimpleFilter('time_publication', array($this, 'timePublicationFunction')),
		);
	}

	public function timePublicationFunction($date) {
		if ($date == null) {
			return "Sin fecha";
		}

		$start_date = $date;
		$since_start = $start_date->diff(new \DateTime(date("Y-m-d") . " " . date("H:i:s")));

		if ($since_start->y == 0) {
			if ($since_start->m == 0) {
				if ($since_start->d == 0) {
					if ($since_start->h == 0) {
						if ($since_start->i == 0) {
							if ($since_start->s == 0) {
								$result = $since_start->s . ' segundos';
							} else {
								if ($since_start->s == 1) {
									$result = $since_start->s . ' segundo';
								} else {
									$result = $since_start->s . ' segundos';
								}
							}
						} else {
							if ($since_start->i == 1) {
								$result = $since_start->i . ' minuto';
							} else {
								$result = $since_start->i . ' minutos';
							}
						}
					} else {
						if ($since_start->h == 1) {
							$result = $since_start->h . ' hora';
						} else {
							$result = $since_start->h . ' horas';
						}
					}
				} else {
					if ($since_start->d == 1) {
                        if ($since_start->h == 1) {
							$result = $since_start->d . ' día y ' .$since_start->h . ' hora';
						} else {
							$result = $since_start->d . ' día y ' . $since_start->h . ' horas';
						}
						//$result = $since_start->d . ' día' . $since_start->h;
					} else {
						$result = $since_start->d . ' días';
					}
				}
			} else {
				if ($since_start->m == 1) {
                    if ($since_start->d == 1) {
                        $result = $since_start->m . ' mes y ' .$since_start->d . ' día';

                    }else{
                        $result = $since_start->m . ' mes y ' .$since_start->d . ' días';
                    }
				} else {
					$result = $since_start->m . ' meses';
				}
			}
		} else {
			if ($since_start->y == 1) {
                if ($since_start->m == 1) {
                     $result = $since_start->y . ' año y '.$since_start->m . ' mes';

                }else{
                     $result = $since_start->y . ' año y '.$since_start->m . ' meses';

                }
			} else {
				$result = $since_start->y . ' años';
			}
		}

		return "Hace " . $result;
	}
	
	public function getName(){
		return 'time_publication_filter';
	}

}
