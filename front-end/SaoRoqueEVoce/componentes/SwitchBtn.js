import React,{useState} from 'react';
import {
Switch
} from 'react-native';

export default function App(props){
    const [ligado,setLigado] = useState(false)
    const toggle=()=> setLigado(previousState => !previousState)
    
  return (
    <Switch
    trackColor={{false:'#414141', true:'#910046'}}
    thumbColor={'#C5C5C5'}
    value={ligado}
    onValueChange={toggle}
    /> 
  );
};


