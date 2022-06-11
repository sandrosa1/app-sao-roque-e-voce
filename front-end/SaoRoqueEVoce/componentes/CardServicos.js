import React, {useState, useEffect} from 'react';
import {
  StyleSheet,
  Text,
  View,
  TouchableOpacity,
  Image,
  Dimensions,
  Linking
} from 'react-native';
import {useNavigation} from '@react-navigation/native';
import axios from 'axios';

export default function App({dados}) {
  const url = `http://www.racsstudios.com/api/v1/apps/${dados?.idApp}`;
  const link ='https://www.google.com/maps/dir/';
  const navigation = useNavigation();
  const [data, setData] = useState();
  const [tododia, setTododia] = useState(false);
  const title = dados?.nomeFantasia;
  const rua = dados?.logradouro + ', ' + dados?.numero;
  const cidade = dados?.localidade
  const cep = dados?.cep
  const contato = dados?.telefone;
  const celular = dados?.celular;
  const email = dados?.email;
  const distancia = 5;
  const img = dados?.img1;

  useEffect(() => {
    loadApi();
  
  }, []);

  async function loadApi() {
    const response = await axios.get(url);
    setData(response.data);
   
  }

  useEffect(() => {
    if (data){
    if (
      data?.complemeto?.semana === data?.complemeto?.sabado &&
      data?.complemeto?.semana === data?.complemeto?.domingo &&
      data?.complemeto?.semana === data?.complemeto?.feriado
    ) {
      setTododia(true);
    }}

  }, [data]);

  const abrirLink = () => {
     Linking.openURL(`https://www.google.com/maps/dir/?api=1&travelmode=driving&dir_action=navigate&destination=Rua,${rua},${cidade}`);
  }
 

  return (
    <View style={estilos.container}>
      <View style={estilos.cardBody}>
        <View style={estilos.conteudo1}>
          <Text style={estilos.title}>{title}</Text>
          <View style={{marginTop: 5}}>
            <View style={estilos.informacao}>
              <Image
                style={estilos.img}
                source={require('../images/servicos/endereco.png')}
              />
              <Text style={estilos.txtConteudo}>{rua}</Text>
            </View>
            <View style={[estilos.informacao, {alignItems: 'flex-start'}]}>
              <Image
                style={estilos.img}
                source={require('../images/servicos/funcionamento.png')}
              />
              <View style={{flex: 1}}>
                {tododia ?
                <View style={[estilos.conteudoFuncionamento, {marginTop: 5}]}>
                  <Text style={estilos.txtFuncionamento}>Todos os dias</Text>
                  <Text style={estilos.txtFuncionamento}>
                    {data?.complemeto?.semana}
                  </Text>
                </View>:
                <View>
                <View style={[estilos.conteudoFuncionamento, {marginTop: 5}]}>
                  <Text style={estilos.txtFuncionamento}>Seg a Sex </Text>
                  <Text style={estilos.txtFuncionamento}>
                    {data?.complemeto?.semana}
                  </Text>
                </View>
                <View style={estilos.conteudoFuncionamento}>
                  <Text style={estilos.txtFuncionamento}>Sábado </Text>
                  <Text style={estilos.txtFuncionamento}>
                    {data?.complemeto?.sabado}
                  </Text>
                </View>
                <View style={estilos.conteudoFuncionamento}>
                  <Text style={estilos.txtFuncionamento}>Domingo </Text>
                  <Text style={estilos.txtFuncionamento}>
                    {data?.complemeto?.domingo}
                  </Text>
                </View>
                <View style={estilos.conteudoFuncionamento}>
                  <Text style={estilos.txtFuncionamento}>Feriado </Text>
                  <Text style={estilos.txtFuncionamento}>
                    {data?.complemeto?.feriado}
                  </Text>
                </View>
              </View>}
              </View>
            </View>
            {contato ? (
              <TouchableOpacity style={estilos.informacao} onPress={()=>{Linking.openURL(`tel:${contato}`)}}>
                <Image
                  style={estilos.img}
                  source={require('../images/servicos/contato.png')}
                />
                <Text style={estilos.txtConteudo}>{contato}</Text>
              </TouchableOpacity>
            ) : (
              <View></View>
            )}
            {celular ? (
              <TouchableOpacity style={estilos.informacao} onPress={()=>{Linking.openURL(`tel:${celular}`)}}>
                <Image
                  style={estilos.img}
                  source={require('../images/servicos/celular.png')}
                />
                <Text style={estilos.txtConteudo}>{celular}</Text>
              </TouchableOpacity>
            ) : (
              <View></View>
            )}
            {email ? (
              <View >
                <TouchableOpacity style={estilos.informacao} onPress={()=>{Linking.openURL(`mailto:${email}`)}}>
                <Image
                  style={estilos.img}
                  source={require('../images/servicos/email.png')}
                />
                <Text style={estilos.txtConteudo}>{email}</Text>
                </TouchableOpacity>
              </View>
            ) : (
              <View></View>
            )}
            {/* <View style={estilos.informacao}>
              <Image
                style={estilos.img}
                source={require('../images/servicos/site.png')}
              />
              <Text style={estilos.txtConteudo}>{contato}</Text>
            </View> */}
            {/* <View style={estilos.informacao}>
              <Image
                style={estilos.img}
                source={require('../images/servicos/facebook.png')}
              />
              <Text style={estilos.txtConteudo}>{contato}</Text>
            </View>
            <View style={estilos.informacao}>
              <Image
                style={estilos.img}
                source={require('../images/servicos/instagram.png')}
              />
              <Text style={estilos.txtConteudo}>{contato}</Text>
            </View>
            <View style={estilos.informacao}>
              <Image
                style={estilos.img}
                source={require('../images/servicos/youtube.png')}
              />
              <Text style={estilos.txtConteudo}>{contato}</Text>
            </View> */}
          </View>
        </View>
        <View
          style={{
            alignItems: 'center',
            padding: 15,
            justifyContent: 'space-between',
          }}>
          <View style={{alignItems: 'center', justifyContent: 'space-between'}}>
            <Text style={estilos.title}>{distancia} km</Text>
            <TouchableOpacity onPress={()=>{abrirLink()}}>
              <Image
                style={estilos.img2}
                source={require('../images/servicos/rota.png')}
              />
            </TouchableOpacity>
          </View>
          <Image style={estilos.img2} source={{uri: img}} />
        </View>
      </View>
    </View>
  );
}

const estilos = StyleSheet.create({
  container: {
    alignItems: 'center',
    paddingVertical: 15,
    marginTop: 10,
  },
  cardBody: {
    width:
      Dimensions.get('window').width - Dimensions.get('window').width * 0.15,
    borderWidth: 2,
    borderRadius: 15,
    borderColor: '#910046',
    flexDirection: 'row',
    justifyContent: 'space-between',
  },
  conteudo1: {
    flex: 1,
    paddingVertical: 15,
    paddingLeft: 10,
  },
  title: {
    fontFamily: 'Roboto-Bold',
    color: '#000',
    fontSize: 18,
  },
  txtConteudo: {
    fontFamily: 'Poppins-Regular',
    color: '#000',
    fontSize: 13,
    paddingLeft: 10,
    top: 2,
  },
  img: {
    height: 25,
    width: 25,
    resizeMode: 'contain',
  },
  img2: {
    height: 35,
    width: 35,
    resizeMode: 'contain',
  },
  informacao: {
    flexDirection: 'row',
    alignItems: 'center',
    marginHorizontal: 5,
    marginVertical: 1,
  },
  txtFuncionamento: {
    fontFamily: 'Poppins-Regular',
    color: '#000',
    fontSize: 11,
    paddingLeft: 10,
  },
  conteudoFuncionamento: {
    flexDirection: 'row',
    marginRight: '20%',
    justifyContent: 'space-between',
    marginVertical: -2,
  },
});
