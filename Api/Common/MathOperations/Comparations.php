<?php

namespace Api\Common\MathOperations;

use Exception\Exception;

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
                continue;
            }
            if(((float)$itensToCompare[$i]['price'] / (float)$itensToCompare[$i]['weight']) < ((float)$bestChoice['price'] / (float)$bestChoice['weight'])){
                $bestChoice = $itensToCompare[$i];
            }
        }
        return $bestChoice;
    }





    public static function convertOptionToUnitMensure(array $option, string $productUnitMensure){


        switch($productUnitMensure){
            case "mcg" : 
                if($option['unit_mensure'] == 'mg'){
                    return (float)$option['wheight'] / 1000;
                }
                
                if($option['unit_mensure'] == 'g'){
                    return (float)$option['wheight'] / 1000000;
                }
                
                if($option['unit_mensure'] == 'kg'){
                    return (float)$option['wheight'] / 1000000000;
                }
                
                return (float)$option['wheight'];    
            break;

            case "mg" : 
                if($option['unit_mensure'] == 'mcg'){
                    return (float)$option['wheight'] * 1000;
                }
                
                if($option['unit_mensure'] == 'g'){
                    return (float)$option['wheight'] * 0.001;
                }
                
                if($option['unit_mensure'] == 'kg'){
                    return (float)$option['wheight'] * 0.000001;
                }
                
                return (float)$option['wheight'];    
            break;
       
            case "g" : 
                if($option['unit_mensure'] == 'mcg'){
                    return (float)$option['wheight'] * 1000000;
                }
                
                if($option['unit_mensure'] == 'mg'){
                    return (float)$option['wheight'] * 1000;
                }
                
                if($option['unit_mensure'] == 'kg'){
                    return (float)$option['wheight'] * 0.001;
                }
                
                return (float)$option['wheight'];    
            break;

            case "kg" : 
                if($option['unit_mensure'] == 'mcg'){
                    return (float)$option['wheight'] * 1000000000;
                }
                
                if($option['unit_mensure'] == 'mg'){
                    return (float)$option['wheight'] * 1000000;
                }
                
                if($option['unit_mensure'] == 'g'){
                    return (float)$option['wheight'] * 1000;
                }
                
                return (float)$option['wheight'];    
            break;

            
            
            case 'cm':
                if ($option['unit_mensure'] == 'mm') {
                    return (float)$option['wheight'] /   10; // Converte milímetros para centímetros
                }
                if ($option['unit_mensure'] == 'm') {
                    return (float)$option['wheight'] /   100; // Converte metros para centímetros
                }
                
                return (float)$option['wheight'];    
            break;

            case 'm':
                if ($option['unit_mensure'] == 'mm') {
                    return (float)$option['wheight'] /   1000; // Converte milímetros para metros
                }
                if ($option['unit_mensure'] == 'cm') {
                    return (float)$option['wheight'] /   100; // Converte centímetros para metros
                }
                
                return (float)$option['wheight'];    
            break;

            case 'mm':
                if ($option['unit_mensure'] == 'cm') {
                    return (float)$option['wheight'] *   10; // Converte centímetros para milímetros
                }
                if ($option['unit_mensure'] == 'm') {
                    return (float)$option['wheight'] *   1000; // Converte metros para milímetros
                }
                
                return (float)$option['wheight'];    
            break;



            case 'cm2':
                if ($option['unit_mensure'] == 'mm2') {
                    return (float)$option['wheight'] /   100; // Converte milímetros quadrados para centímetros quadrados
                }
                if ($option['unit_mensure'] == 'm2') {
                    return (float)$option['wheight'] /   1000000; // Converte metros quadrados para centímetros quadrados
                }
                
                return (float)$option['wheight'];    
            break;
            
            case 'm2':
                if ($option['unit_mensure'] == 'mm2') {
                    return (float)$option['wheight'] /   1000000; // Converte milímetros quadrados para metros quadrados
                }
                if ($option['unit_mensure'] == 'cm2') {
                    return (float)$option['wheight'] /   10000; // Converte centímetros quadrados para metros quadrados
                }
                
                return (float)$option['wheight'];    
            break;
            
            case 'mm2':
                if ($option['unit_mensure'] == 'cm2') {
                    return (float)$option['wheight'] *   100; // Converte centímetros quadrados para milímetros quadrados
                }
                if ($option['unit_mensure'] == 'm2') {
                    return (float)$option['wheight'] *   1000000; // Converte metros quadrados para milímetros quadrados
                }
                
                return (float)$option['wheight'];    
            break;



            case 'ml':
                if ($option['unit_mensure'] == 'mm3') {
                    return (float)$option['wheight'] /   1000; // Converte milímetros cúbicos para mililitros
                }
                if ($option['unit_mensure'] == 'l') {
                    return (float)$option['wheight'] /   1000000; // Converte litros para mililitros
                }
                if ($option['unit_mensure'] == 'm3') {
                    return (float)$option['wheight'] /   1000000000; // Converte metros cúbicos para mililitros
                }
                
                return (float)$option['wheight'];    
            break;
            
            case 'l':
                if ($option['unit_mensure'] == 'mm3') {
                    return (float)$option['wheight'] /   1000; // Converte milímetros cúbicos para litros
                }
                if ($option['unit_mensure'] == 'ml') {
                    return (float)$option['wheight'] /   1000; // Converte mililitros para litros
                }
                if ($option['unit_mensure'] == 'm3') {
                    return (float)$option['wheight'] /   1000000; // Converte metros cúbicos para litros
                }
                
                return (float)$option['wheight'];    
            break;
            
            case 'm3':
                if ($option['unit_mensure'] == 'mm3') {
                    return (float)$option['wheight'] /   1000000000; // Converte milímetros cúbicos para metros cúbicos
                }
                if ($option['unit_mensure'] == 'l') {
                    return (float)$option['wheight'] /   1000; // Converte litros para metros cúbicos
                }
                if ($option['unit_mensure'] == 'ml') {
                    return (float)$option['wheight'] /   1000000; // Converte mililitros para metros cúbicos
                }
                
                return (float)$option['wheight'];    
            break;
            
            case 'mm3':
                if ($option['unit_mensure'] == 'cm3') {
                    return (float)$option['wheight'] *   1000; // Converte centímetros cúbicos para milímetros cúbicos
                }
                if ($option['unit_mensure'] == 'm3') {
                    return (float)$option['wheight'] *   1000000; // Converte metros cúbicos para milímetros cúbicos
                }
                
                return (float)$option['wheight'];    
            break;

            default : 
                Exception::throw('Invalid unit mensure', 200);
        }
    }

}