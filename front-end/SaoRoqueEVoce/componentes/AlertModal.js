import React,{useState} from 'react';
import {
Modal,
StyleSheet,
View,
Text,
Image,
TouchableOpacity
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import AlertBack from './AlertBack';

export default function App(props){
    const navigation = useNavigation();
    const [ligado,setLigado] = useState(false)    
  return (
      <View>
          <AlertBack/>
            <View>
            <Modal visible={true} transparent={true}>
                <View style={{flex:1, alignItems:'center',}}>
                    <View style={estilos.container}>
                        <View style={{alignItems:'flex-end'}}>
                            <TouchableOpacity>
                                <Image source={require('../images/configuracao/close.png')}/>
                            </TouchableOpacity>
                        </View>
                        <View style={{flex:1, alignItems:'center',justifyContent:'center'}}>
                                <Image source={require('../images/configuracao/dangericon.png')}/>
                                <Text style={[estilos.txt,{paddingVertical:5}]}>Você deseja deletar a sua conta?</Text>
                                <View style={{flexDirection:'row', padding:10}}>
                                <TouchableOpacity style={estilos.btnBg}>
                                    <Text style={[estilos.txt,{color:'#707070'}]}>Não</Text>
                                </TouchableOpacity> 
                                <TouchableOpacity style={[estilos.btnBg,{backgroundColor:'#920046'}]}>
                                    <Text style={[estilos.txt,{color:'#FFF'}]}>Sim</Text>
                                </TouchableOpacity> 
                            </View>
                        </View>                    
                    </View>
                </View>
            </Modal>
        </View>        
      </View>
  );
};

const estilos = StyleSheet.create({
    container:{
        alignSelf:'center',
        width:350,
        height:230,
        padding:20,
        borderRadius:30,
        backgroundColor:'#fff',
        elevation:5,
        top:'25%'        
    },
    btnBg:{
        width:100,
        height:45,backgroundColor:'#CCC',
        borderRadius:34, alignItems:'center',
        justifyContent:'center',
        marginHorizontal:20
    },
    txt:{
        fontSize:17,
        fontFamily:'Poppins-Regular',

    }
  });
  


