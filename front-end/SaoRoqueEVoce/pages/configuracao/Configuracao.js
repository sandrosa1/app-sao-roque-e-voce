import React, {useState, useEffect} from 'react';
import {
  StyleSheet,
  Text,
  View,
  Modal,
  Image,
  TouchableOpacity,
  ActivityIndicator,
} from 'react-native';
import {useNavigation} from '@react-navigation/native';
import Header from '../../componentes/Header';
import AsyncStorage from '@react-native-async-storage/async-storage';
import Globais from '../../componentes/Globais';
import {useIsFocused} from '@react-navigation/native';

export default function App() {
  const navigation = useNavigation();
  const isFocused = useIsFocused();
  const [mostrar, setMostrar] = useState(false);
  const [retorno, setRetorno] = useState(false);
  const [loadingResponse, setLoadingResponse] = useState(false);
  const [sair, setSair] = useState(false);
  const [opcao, setOpcao] = useState(false);
  const [deletar, setDeletar] = useState(false);
  const [msg, setMsg] = useState(false);
  const [img, setImg] = useState(
    require('../../images/configuracao/dangericon.png'),
  );
  const [mostrarindicator, setMostrarindicator] = useState(false);

  const logout = async () => {
    try {
      await AsyncStorage.clear();
    } catch (e) {
      console.log(e);
    }
    Globais.dados = null;
    if (opcao == 'sair') {
      setSair(false);
      setMostrarindicator(true);
      setTimeout(() => {
        setMostrarindicator(false);
        navigation.navigate('Index');
      }, 1500);
    } else {
      navigation.navigate('Index');
    }
  };

  function optionBtn(opcao) {
    if (opcao == 'sair') {
      setMsg('Deseja sair da sua conta?');
      setImg(require('../../images/configuracao/warningicon.png'));
      setOpcao('sair');
      setSair(true);
    } else {
      setMsg('Você deseja deletar a sua conta?');
      setImg(require('../../images/configuracao/dangericon.png'));
      setOpcao('deletar');
      setSair(true);
    }
  }

  useEffect(() => {
    const dadosdousuario = async () => {
      const json = await AsyncStorage.getItem('usuario');
      if (json) {
        Globais.dados = JSON.parse(json);
      }
    };
    dadosdousuario();
  }, [isFocused]);
  console.log(Globais.dados);
  return (
    <View style={estilos.container}>
      <View style={{flex: 3}}>
        <Header goingback={true} space={true} rota={'Home'} />

        <View style={estilos.containerMenu}>
          <View style={estilos.containerOpcao}>
            <TouchableOpacity
              style={estilos.btn}
              onPress={() => navigation.navigate('Perfil')}>
              <Image
                style={estilos.img}
                source={require('../../images/configuracao/perfil.png')}
              />
              <Text style={estilos.txt}>Perfil</Text>
            </TouchableOpacity>
          </View>
        </View>
        <View style={estilos.containerMenu}>
          <View style={estilos.containerOpcao}>
            <TouchableOpacity
              style={estilos.btn}
              onPress={() => navigation.navigate('Comentarios')}>
              <Image
                style={estilos.img}
                source={require('../../images/configuracao/comentarios.png')}
              />
              <Text style={estilos.txt}>Comentários</Text>
            </TouchableOpacity>
          </View>
        </View>
        <View style={estilos.containerMenu}>
          <View style={estilos.containerOpcao}>
            <TouchableOpacity
              style={estilos.btn}
              onPress={() => navigation.navigate('Ajustes')}>
              <Image
                style={estilos.img}
                source={require('../../images/configuracao/configuracao.png')}
              />
              <Text style={estilos.txt}>Configurações</Text>
            </TouchableOpacity>
          </View>
        </View>
        <View style={estilos.containerMenu}>
          <View style={estilos.containerOpcao}>
            <TouchableOpacity
              style={estilos.btn}
              onPress={() => navigation.navigate('Notificacao')}>
              <Image
                style={estilos.img}
                source={require('../../images/configuracao/notificacao.png')}
              />
              <Text style={estilos.txt}>Notificações</Text>
            </TouchableOpacity>
          </View>
        </View>
        <View style={estilos.containerMenu}>
          <View style={estilos.containerOpcao}>
            <TouchableOpacity
              style={estilos.btn}
              onPress={() => navigation.navigate('FaleConosco')}>
              <Image
                style={estilos.img}
                source={require('../../images/configuracao/suporte.png')}
              />
              <Text style={estilos.txt}>Fale Conosco</Text>
            </TouchableOpacity>
          </View>
        </View>
        <View style={estilos.containerMenu}>
          <View style={estilos.containerOpcao}>
            <TouchableOpacity
              style={estilos.btn}
              onPress={() => navigation.navigate('QuemSomos')}>
              <Image
                style={estilos.img}
                source={require('../../images/configuracao/quemsomos.png')}
              />
              <Text style={estilos.txt}>Quem Somos</Text>
            </TouchableOpacity>
          </View>
        </View>
      </View>

      <View style={{flex: 1}}>
        {Globais?.dados ? (
          <View style={estilos.containerBtn}>
            <TouchableOpacity
              style={estilos.btn2}
              onPress={() => {
                optionBtn('sair');
              }}>
              <Text
                style={{
                  fontSize: 24,
                  fontFamily: 'Poppins-Regular',
                  color: '#fff',
                  padding: 5,
                }}>
                Sair da Conta
              </Text>
            </TouchableOpacity>
          </View>
        ) : (
          <View style={estilos.containerBtn}>
            <TouchableOpacity
              style={[estilos.btn2, {backgroundColor: '#C980A3'}]}
              onPress={() => {
                navigation.navigate('Login');
              }}>
              <Text
                style={{
                  fontSize: 24,
                  fontFamily: 'Poppins-Regular',
                  color: '#920049',
                  padding: 5,
                }}>
                ENTRAR
              </Text>
            </TouchableOpacity>
            <TouchableOpacity
              style={[estilos.btn2, {backgroundColor: '#920049'}]}
              onPress={() => {
                navigation.navigate('Cadastro');
              }}>
              <Text
                style={{
                  fontSize: 24,
                  fontFamily: 'Poppins-Regular',
                  color: '#D8D8D8',
                  padding: 5,
                  letterSpacing: 2,
                }}>
                CADASTRAR
              </Text>
            </TouchableOpacity>
          </View>
        )}
      </View>

      <View>
        <Modal visible={sair} transparent={true}>
          <View
            style={{
              flex: 1,
              alignItems: 'center',
              backgroundColor: 'rgba(0, 0 , 0, 0.8)',
            }}>
            <View style={estilos.containerModal}>
              <View style={{alignItems: 'flex-end'}}>
                <TouchableOpacity
                  onPress={() => {
                    setSair(false);
                  }}>
                  <Image
                    style={{height: 25, width: 25}}
                    source={require('../../images/configuracao/close.png')}
                  />
                </TouchableOpacity>
              </View>
              <View
                style={{
                  flex: 1,
                  alignItems: 'center',
                  justifyContent: 'center',
                }}>
                <Image source={img} />
                <Text
                  style={[estilos.txt2, {paddingVertical: 10, fontSize: 14}]}>
                  {msg}
                </Text>
                <View style={{flexDirection: 'row', padding: 0}}>
                  <TouchableOpacity
                    style={estilos.btnBg}
                    onPress={() => {
                      setSair(false);
                    }}>
                    <Text style={[estilos.txtModal, {color: '#707070'}]}>
                      Não
                    </Text>
                  </TouchableOpacity>
                  <TouchableOpacity
                    style={[estilos.btnBg, {backgroundColor: '#920046'}]}
                    onPress={() => {
                      if (opcao == 'sair') {
                        logout();
                      } else {
                        setDeletar(true);
                      }
                    }}>
                    <Text style={[estilos.txtModal, {color: '#FFF'}]}>Sim</Text>
                  </TouchableOpacity>
                </View>
              </View>
            </View>
          </View>
        </Modal>
      </View>

      <View>
        <Modal visible={mostrarindicator} transparent={true}>
          <View
            style={{
              flex: 1,
              alignItems: 'center',
              backgroundColor: 'rgba(0, 0 , 0, 0.8)',
            }}>
            <View style={estilos.containerModal}>
              <View
                style={{
                  flex: 1,
                  alignItems: 'center',
                  justifyContent: 'center',
                }}>
                <Text style={[estilos.txtModal, {paddingVertical: 10}]}>
                  Saindo...
                </Text>
                <ActivityIndicator size="large" color="#910046" />
              </View>
            </View>
          </View>
        </Modal>
      </View>
      <View>
        <Modal visible={retorno} transparent={true}>
          <View
            style={{
              flex: 1,
              alignItems: 'center',
              backgroundColor: 'rgba(0, 0 , 0, 0.8)',
            }}>
            <View style={[estilos.containerModal, {height: 230, top: '30%'}]}>
              <View style={{alignItems: 'flex-end'}}>
                <TouchableOpacity
                  onPress={() => {
                    setRetorno(false);
                    setSair(false);
                    setDeletar(false);
                    logout();
                  }}>
                  <Image
                    style={{height: 25, width: 25}}
                    source={require('../../images/configuracao/close.png')}
                  />
                </TouchableOpacity>
              </View>
              <View
                style={{
                  flex: 1,
                  alignItems: 'center',
                  justifyContent: 'center',
                }}>
                {loadingResponse ? (
                  <View
                    style={{
                      marginBottom: 60,
                      alignItems: 'center',
                      justifyContent: 'center',
                    }}>
                    <ActivityIndicator size={75} color="#910046" />
                  </View>
                ) : (
                  <View
                    style={{alignItems: 'center', justifyContent: 'center'}}>
                    <Image source={img} />
                    <Text
                      style={[
                        estilos.txtModal,
                        {textAlign: 'center', paddingVertical: 15},
                      ]}>
                      {msg}
                    </Text>
                  </View>
                )}
              </View>
            </View>
          </View>
        </Modal>
      </View>
    </View>
  );
}

const estilos = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
  },
  containerMenu: {
    paddingHorizontal: 40,
    marginTop: 2,
  },
  containerOpcao: {
    borderBottomWidth: 1,
    paddingVertical: 15,
    paddingHorizontal: 5,
    borderColor: '#C4C4C4',
  },
  txt: {
    fontFamily: 'Roboto-Bold',
    fontSize: 20,
    color: '#000',
    paddingLeft: 20,
  },
  btn: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  img: {
    height: 35,
    width: 35,
    resizeMode: 'contain',
  },
  containerBtn: {
    flex: 1,
    justifyContent: 'flex-end',
    alignItems: 'center',
    bottom: '20%',
  },
  btn2: {
    marginTop: 25,
    width: '80%',
    height: 45,
    borderRadius: 33,
    backgroundColor: '#910046',
    alignItems: 'center',
    justifyContent: 'center',
  },
  containerModal: {
    alignSelf: 'center',
    width: 350,
    height: 230,
    padding: 20,
    borderRadius: 30,
    backgroundColor: '#fff',
    elevation: 5,
    top: '25%',
  },
  btnBg: {
    width: 100,
    height: 45,
    backgroundColor: '#CCC',
    borderRadius: 34,
    alignItems: 'center',
    justifyContent: 'center',
    marginHorizontal: 20,
  },
  txtModal: {
    fontSize: 17,
    fontFamily: 'Poppins-Regular',
    color: '#000',
  },
  txt2: {
    bottom: 5,
    fontSize: 12,
    fontFamily: 'Poppins-Regular',
    color: '#414141',
  },
});
