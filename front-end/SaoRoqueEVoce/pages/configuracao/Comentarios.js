import React, {useState, useEffect} from 'react';
import {
  StyleSheet,
  Text,
  View,
  Image,
  TouchableOpacity,
  Modal,
  FlatList,
  ActivityIndicator,
  KeyboardAvoidingView
} from 'react-native';
import Header from '../../componentes/Header';
import SeparadorComentario from '../../componentes/SeparadorComentario';
import CardMeusComentarios from '../../componentes/CardMeusComentarios';
import Globais from '../../componentes/Globais';
import {useIsFocused} from '@react-navigation/native';
import axios from 'axios';
import {Buffer} from 'buffer';

export default function App({route, navigation}) {
  const url = 'http://www.racsstudios.com/api/v1/commentuser/all';
  const [loading, setLoading] = useState(false);
  const [dados, setDados] = useState([]);
  const [filtro, setFiltro] = useState(dados);
  const [additem, setAdditem] = useState(4);
  const [verificarUser, setVerificarUser] = useState(false);
  const isFocused = useIsFocused();
  const reload = route.params?.hookReload;

  useEffect(() => {
    loadApi();
  }, [isFocused, reload, additem]);

  if (!Globais.dados?.usernome && verificarUser != true) {
    setVerificarUser(true);
  }

  async function loadApi() {
    if (loading) return;
    setLoading(true);
    let username = Globais.dados?.useremail;
    let password = Globais.dados?.usertoken;
    const token = Buffer.from(`${username}:${password}`, 'utf8').toString(
      'base64',
    );
    axios
      .get(url, {headers: {Authorization: `Basic ${token}`}})
      .then(response => {
        setTimeout(() => {
          setDados(response.data.comments);
          setLoading(false);
        }, 500);
        console.log(response.data);
      })
      .catch(error => {
        setDados();
        setFiltro();
        console.log(error.response.data);
        setLoading(false);
      });
  }

  useEffect(() => {
    if (dados) {
      setFiltro(
        dados.filter((item, indice) => {
          if (item.segmento !== 'servicos' && indice < additem) {
            return true;
          }
        }),
      );
    }
  }, [dados]);

  return (
    <View style={estilos.container}>      
      <View style={{marginVertical: 0}}>
        <FlatList
          showsVerticalScrollIndicator={false}
          ItemSeparatorComponent={SeparadorComentario}
          data={filtro}
          keyExtractor={item => String(item.idComment)}
          renderItem={({item}) => <CardMeusComentarios data={item} />}
          ListHeaderComponent={
            <>
              <Header goingback={true} space={true} />
              <View style={{paddingHorizontal: 30}}>
                <Text style={estilos.h1}>Meus Comentários</Text>
                <Text style={estilos.txt}>
                  Reveja ou apague seus comentários.
                </Text>
              </View>
            </>
          }
          onEndReached={() => {
            setAdditem(additem + 3);
          }}
          ListEmptyComponent={
            <>
              {verificarUser ? (
                <View>
                   <View style={{marginHorizontal: 30, marginVertical: 20}}>
                  <View style={{alignItems: 'center'}}>
                    <Image
                      style={{width:50, height:50}}
                      source={require('../../images/paginadetalhes/warning-purple.png')}
                    />
                    <Text
                      style={{
                        fontFamily: 'Poppins-Regular',
                        fontSize: 16,
                        color: '#000',
                        textAlign:'center',
                        marginTop:15
                      }}>
                      Entre ou cadastre-se para ver todos os seus comentários!
                    </Text>
                  </View>
                  <View
                    style={{
                      flexDirection: 'row',
                      alignItems: 'center',
                      justifyContent: 'space-around',
                      marginTop: 20,
                    }}>
                    <TouchableOpacity
                      style={estilos.btn2}
                      onPress={() =>
                        navigation.navigate('Login')
                      }>
                      <Text style={estilos.txtBtn2}>ENTRAR</Text>
                    </TouchableOpacity>
                    <TouchableOpacity
                      style={[estilos.btn2, {backgroundColor: '#920046'}]}
                      onPress={() =>
                        navigation.navigate('Cadastro')
                      }>
                      <Text style={[estilos.txtBtn2, {color: 'white'}]}>
                        CADASTRAR
                      </Text>
                    </TouchableOpacity>
                  </View>
                </View>
                </View>
              ) : !dados ? (
                <View>
                   <View style={{marginHorizontal: 30, marginVertical: 50}}>
                  <View style={{alignItems: 'center'}}>
                    <Image
                      style={{width:50, height:50}}
                      source={require('../../images/paginadetalhes/warning-purple.png')}
                      />
                    <Text
                      style={{
                          fontFamily: 'Poppins-Regular',
                          fontSize: 16,
                          color: '#000',
                          textAlign: 'center',
                          marginVertical: 10,
                        }}>
                      Você não fez nenhum comentário ainda, avalie os estabelecimentos que voce conhece!
                    </Text>
                    <Text
                      style={{
                          fontFamily: 'Poppins-Bold',
                          fontSize: 16,
                          color: '#000',
                          textAlign: 'center',
                        }}>
                      Compartilhe sua opinião!
                    </Text>
                  </View>
                </View> 
                </View>
              ) : (
                <View
                  style={{
                    marginTop: 150,
                    alignItems: 'center',
                    justifyContent: 'center',
                  }}>
                  <ActivityIndicator size={50} color="#910046" />
                </View>
              )}
            </>
          }
          onEndReachedThreshold={0.15}
          ListFooterComponent={
            <>
              {loading && additem > 5 ? (
                <View
                  style={{
                    marginBottom: 10,
                    alignItems: 'center',
                    justifyContent: 'center',
                  }}>
                  <ActivityIndicator size={35} color="#910046" />
                </View>
              ) : (
                <View style={{marginBottom: 45}}></View>
              )}
            </>
          }
        />
      </View>
    </View>
  );
}

const estilos = StyleSheet.create({
  container: {
  },
  h1: {
    fontSize: 24,
    fontFamily: 'Poppins-Regular',
    color: '#910046',
    textAlign: 'left',
  },
  txt: {
    bottom: 5,
    fontSize: 12,
    fontFamily: 'Poppins-Regular',
    color: '#414141',
  },
  btn: {
    marginTop: 25,
    width: '80%',
    height: 45,
    borderRadius: 33,
    backgroundColor: '#910046',
    alignItems: 'center',
    justifyContent: 'center',
  },
  txtTitle: {
    fontSize: 18,
    fontFamily: 'Roboto-Bold',
    color: '#000',
  },
  txtData: {
    fontSize: 12,
    fontFamily: 'Poppins-Regular',
    color: '#920046',
  },
  txtComantario: {
    fontSize: 14,
    fontFamily: 'Poppins-Regular',
    color: '#414141',
  },
  btn2: {
    backgroundColor: 'rgba(146, 0 , 70, 0.28)',
    borderRadius: 5,
    borderColor: '#920046',
    borderWidth: 1,
    height: 45,
    width: 140,
  },
});
