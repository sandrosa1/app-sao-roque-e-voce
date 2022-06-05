import React,{useState} from 'react';
import {
  StyleSheet,
  Text,
  View,
  TouchableOpacity,
  Image,
  Dimensions,
} from 'react-native';
import {useNavigation} from '@react-navigation/native';
import axios from 'axios';

export default function App({dados}) {
  const navigation = useNavigation();
  const [desligaBtn, setDesligaBtn] = useState(false)
  const [btnsim, setBtnsim] = useState({
    backgroundColor: 'rgba(146, 0 , 70, 0.28)',
    borderRadius: 5,
    borderColor: '#920046',
    borderWidth: 1,
    height: 23,
    width: 45,
    marginRight: 10,
  },)
  const [btnnao, setBtnnao] = useState({
    backgroundColor: 'rgba(146, 0 , 70, 0.28)',
    borderRadius: 5,
    borderColor: '#920046',
    borderWidth: 1,
    height: 23,
    width: 45,
    marginRight: 10,
  },)
  const [txtsim, setTxtsim]= useState({
    flex: 1,
    fontSize: 10,
    textAlign: 'center',
    textAlignVertical: 'center',
    color: '#920046',
    fontFamily:'Roboto-Bold'
  },)
  const [txtnao, setTxtnao]= useState({
    flex: 1,
    fontSize: 10,
    textAlign: 'center',
    textAlignVertical: 'center',
    color: '#920046',
    fontFamily:'Roboto-Bold'
  },)

  let title = dados.nome;
  let datacompleta = dados.data.substr(0, 10);
  let comentario = dados.comentario;
  let estrelas = dados.avaliacao;

  let messtr = '';
  switch (datacompleta.substr(5, 2)) {
    case '01':
      messtr = 'Janeiro';
      break;
    case '02':
      messtr = 'Fevereiro';
      break;
    case '03':
      messtr = 'Março';
      break;
    case '04':
      messtr = 'Abril';
      break;
    case '05':
      messtr = 'Maio';
      break;
    case '06':
      messtr = 'Junho';
      break;
    case '07':
      messtr = 'Julho';
      break;
    case '08':
      messtr = 'Agosto';
      break;
    case '09':
      messtr = 'Setembro';
      break;
    case '10':
      messtr = 'Outubro';
      break;
    case '11':
      messtr = 'Novembro';
      break;
    case '12':
      messtr = 'Dezembro';
      break;
  }

  let dataconvertida =
    datacompleta.substr(8, 2) + ' ' + messtr + ' ' + datacompleta.substr(0, 4);

  let arrayestrela = [];

  let i = 0;
  for (i = 0; i < 5; i++) {
    if (estrelas > 0.5) {
      arrayestrela[i] = require('../images/paginadetalhes/star1.png');
      estrelas = estrelas - 1;
    } else {
      if (estrelas <= 0.5 && estrelas > 0) {
        arrayestrela[i] = require('../images/paginadetalhes/star2.png');
        estrelas = 0;
      } else {
        arrayestrela[i] = require('../images/paginadetalhes/star0.png');
      }
    }
  }
const avaliarcomentario = (avaliacao) =>{
  axios
  .get(`http:/www.racsstudios.com/api/v1/util?idComment=${dados.idComment}&util=${avaliacao}`)
  .then(response => {    
    console.log(response.data)
  })
  .catch(error => {
   console.log(error.data)
  });
  navigation.navigate('PaginaDetalhesComentario', {
    hookReload: 'hook' + new Date(),
    id: dados.idApp,
  });
  setDesligaBtn(true)
  if(avaliacao == 1){
    setBtnsim({
      backgroundColor: '#920046',
      borderRadius: 5,
      borderColor: '#E1E1E1',
      borderWidth: 1,
      height: 23,
      width: 45,
      marginRight: 10,
    },)
    setTxtsim({
      flex: 1,
      fontSize: 10,
      textAlign: 'center',
      textAlignVertical: 'center',
      color: 'white',
      fontFamily:'Roboto-Bold'
    },
  )
  } else {
    setBtnnao({
      backgroundColor: '#920046',
      borderRadius: 5,
      borderColor: '#E1E1E1',
      borderWidth: 1,
      height: 23,
      width: 45,
      marginRight: 10,
  })
  setTxtnao({
      flex: 1,
      fontSize: 10,
      textAlign: 'center',
      textAlignVertical: 'center',
      color: '#E1E1E1',
      fontFamily:'Roboto-Bold'
    },
  )
}}
console.log(dados)

  return (
    <View style={estilos.cardBody}>
      <View
        style={{
          width:
            Dimensions.get('window').width -
            Dimensions.get('window').width * 0.15,
          padding: 10,
        }}>
        <View
          style={{
            flexDirection: 'row',
            justifyContent: 'space-between',
            alignItems: 'flex-end',
          }}>
          <View style={{flexDirection: 'row', alignItems: 'center'}}>
            <View style={{marginRight: 5, width: 40, height: 40}}>
              <Image
                style={{height: 40, width: 40, resizeMode: 'contain'}}
                source={require('../images/paginadetalhes/avatar.png')}
              />
            </View>
            <View>
              <Text style={estilos.txtTitle}>{title}</Text>
              <View style={{flexDirection: 'row'}}>
                <Image style={estilos.star} source={arrayestrela[0]} />
                <Image style={estilos.star} source={arrayestrela[1]} />
                <Image style={estilos.star} source={arrayestrela[2]} />
                <Image style={estilos.star} source={arrayestrela[3]} />
                <Image style={estilos.star} source={arrayestrela[4]} />
              </View>
            </View>
          </View>
          <View style={{position: 'absolute', right:0,alignSelf:'flex-end'}}>
            <Text style={[estilos.txtData,{bottom:-6}]}>{dataconvertida}</Text>
          </View>
        </View>
        <View style={{flexDirection: 'row', alignItems: 'center'}}>
          <View style={{paddingVertical: 10}}>
            <Text style={estilos.txtComantario}>{comentario}</Text>
          </View>
        </View>

        <View
          style={{
            width: '100%',
            flexDirection: 'row',
            justifyContent: 'space-between',
            alignItems: 'center',
          }}>
          <Text style={estilos.txtData}>Essa informação foi útil?</Text>
          <View style={{flexDirection: 'row'}}>
            <TouchableOpacity style={btnsim} onPress={()=>{avaliarcomentario(1)}} disabled={desligaBtn}>
              <Text style={txtsim}>Sim({dados.utilSim})</Text>
            </TouchableOpacity>
            <TouchableOpacity style={btnnao} onPress={()=>{avaliarcomentario(0)}} disabled={desligaBtn}>
              <Text style={txtnao}>Não({dados.utilNao})</Text>
            </TouchableOpacity>
          </View>
        </View>
      </View>
    </View>
  );
}

const estilos = StyleSheet.create({
  txtTitle: {
    fontSize: 17,
    fontFamily: 'Roboto-Bold',
    color: '#000',
  },
  txtData: {
    fontSize: 12.5,
    fontFamily: 'Poppins-Regular',
    color: '#920046',    
  },
  txtComantario: {
    fontSize: 14,
    fontFamily: 'Poppins-Regular',
    color: '#414141',
  },
  miniBtn: {
    backgroundColor: 'rgba(146, 0 , 70, 0.28)',
    borderRadius: 5,
    borderColor: '#920046',
    borderWidth: 1,
    height: 23,
    width: 45,
    marginRight: 10,
  },
  txtMiniBtn: {
    flex: 1,
    fontSize: 10,
    textAlign: 'center',
    textAlignVertical: 'center',
    color: '#920046',
    fontFamily:'Roboto-Bold'
  },
  star: {
    width: 20,
    height: 20,
  },
  cardBody: {
    alignItems: 'center',
    backgroundColor: '#F4F4F4',
    marginHorizontal: 20,
    borderRadius: 15,
    paddingVertical: 15,
    marginVertical: 15,
    elevation: 5,
    shadowColor: '#000',
    shadowOpacity: 1,
    shadowOffset: {
      width: 2,
      height: 3,
    },
  },
});
