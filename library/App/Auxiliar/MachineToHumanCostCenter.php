<?php
/**
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 *
 */
class App_Auxiliar_MachineToHumanCostCenter
{

    /**
     * 
     * @param string $code
     */
    public static function translate ($code)
    {

        $optimus = new App_User_Service_Optimus();
        $name = $optimus->machineToHuman($code);
        return $name['act_name'];
    }

    /**
     * 
     * @param string $costCenter
     */
    public static function clean ($costCenter)
    {

        switch ($costCenter) {
            case 'Impressão':
                return 'Impressão';
                break;
            case 'Auxiliar Máquina 006':
                return 'Impressão';
                break;
            case 'Espera de aprovação':
                return 'Acabamentos';
                break;
            case 'Auxiliar Máquina 119':
                return 'Acabamentos';
                break;
            case 'Auxiliar Máquina 112':
                return 'Acabamentos';
                break;
            case 'Desenhar/Paginar embalagem':
                return 'Prepress';
            case 'Falta de trabalho':
                return 'Prepress';
                break;
            case 'Mudança de cor directa':
                return 'Impressão';
                break;
            case 'Afinação da impressão':
                return 'Impressão';
                break;
            case 'Auxiliar Máquina 007':
                return 'Impressão';
                break;
            case 'Afinar c/vinco c/braille c/des':
                return 'Acabamentos';
                break;
            case 'Cortar e vincar com descasque':
                return 'Acabamentos';
                break;
            case 'Descasca':
                return 'Acabamentos';
                break;
            case 'Afinar caixas fundo normal':
                return 'Acabamentos';
                break;
            case 'Colagem de fundo normal':
                return 'Acabamentos';
                break;
            case 'Cortar e vincar':
                return 'Acabamentos';
                break;
            case 'Cortar papel/cartolina impress':
                return 'Impressão';
                break;
            case 'Auxiliar Máquina 109':
                return 'Impressão';
                break;
            case 'Espera de chapas':
                return 'Impressão';
                break;
            case 'Cortar e vincar sem descasque':
                return 'Acabamentos';
                break;
            case 'Afinar para cortar e vincar':
                return 'Acabamentos';
                break;
            case 'Cortar papel/cartolina branco':
                return 'Impressão';
                break;
            case 'Geração de pdf\'s':
                return 'Prepress';
                break;
            case 'Afinar corte e vinco c/ descas':
                return 'Acabamentos';
                break;
            case 'Afinar corte e vinco s/ descas':
                return 'Acabamentos';
                break;
            case 'Limpeza da máquina':
                return 'Acabamentos';
                break;
            case 'Auxiliar Máquina 120':
                return 'Impressão';
                break;
            case 'Auxiliar Máquina 082':
                return 'Acabamentos';
                break;
            case 'Afinar p/cortar e vincar':
                return 'Acabamentos';
                break;
            case 'Descascar':
                return 'Acabamentos';
                break;
            case 'Afinar corte e vinco c/braille':
                return 'Acabamentos';
                break;
            case 'Verif ficheiros incompleta mkt':
                return 'Prepress';
                break;
            case 'Colagem de canelado':
                return 'Acabamentos';
                break;
            case 'Embalar Diversos':
                return 'Acabamentos';
                break;
            case 'Espera de papel':
                return 'Impressão';
                break;
            case 'Afinar c/vinco c/braille s/des':
                return 'Acabamentos';
                break;
            default:
                return $costCenter;
                break;
        }
    }
}
?>