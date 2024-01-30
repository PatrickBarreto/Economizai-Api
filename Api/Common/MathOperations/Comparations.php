<?php

namespace Api\Common\MathOperations;

/**
 * A classe Comparations é responsável por servir o app com os principais calculos de comparação de produtos, calculos que são genéricos aos casos de uso,
 * onde a única diferença são os valores e quantidades de itens a se comparar. 
 * 
 * A classe deve ter métodos centrais e métodos privados abstraindo as ações de uma ou mais comparação
 */
class Comparations {

    //Unidades de medida
    const UNITIES_MEANSURE = [
                                "weight" => ['mcg', 'mg', 'g', 'kg'],
                                "lenght" => ['mm', 'cm', 'm'],
                                "area"   => ['mm2', 'cm2', 'm2'],
                                "volume" => ['ml', 'l', 'c3', 'm3']
                            ];

    /**
     * Método responsável por comparar os dados enviados na request
     *
     * @param array
     * @return array
     */
    public static function compare(array $data){
        return self::choiceMethodCalc(self::findMensureCalc($data['calcType']), $data['itensToCopare']);
    }

    /**
     * Método responsável por escolher o método de calculo de acordo com o tipo de medida do item
     *
     * @param string $classCalc
     * @param array $itens
     * @return void
     */
    private static function choiceMethodCalc(string $classCalc, array $itens) {
        switch($classCalc) {
            case 'weight' : return self::weightCompare($itens);
            break;
        }
    }

    /**
     * Método responsável por identificar a classe pela unidade de medida do calculo solicitado
     *
     * @param string $type
     * @return string
     */
    private static function findMensureCalc(string $type){
        foreach(self::UNITIES_MEANSURE as $mensure=>$value){
            if(in_array($type, $value)) {
                return $mensure;
            }
        }
    }


    /**
     * Método responsável por comparar itens por peso e descobrir qual é o mais barato por medida
     *
     * @param array $itensToCompare
     * @return array
     */
    private static function weightCompare(array $itensToCompare){
        for($i=0; $i < count($itensToCompare); $i++){
            if($i === 0){
                $bestChoice = $itensToCompare[$i];
            }
            if(($itensToCompare[$i]['price'] / $itensToCompare[$i]['weight']) < ($bestChoice['price'] / $bestChoice['weight'])){
                $bestChoice = $itensToCompare[$i];
            }
        }
        return $bestChoice;
    }

}