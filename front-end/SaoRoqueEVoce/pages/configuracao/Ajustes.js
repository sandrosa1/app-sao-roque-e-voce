import React, {useState} from 'react';
import {
  StyleSheet,
  Text,
  View,
  TouchableOpacity,
  Image,
  Modal,
  ActivityIndicator,
  TextInput,
} from 'react-native';
import Header from '../../componentes/Header';
import SwitchBtn from '../../componentes/SwitchBtn';
import {useNavigation} from '@react-navigation/native';
import AsyncStorage from '@react-native-async-storage/async-storage';
import Globais from '../../componentes/Globais';
import {Buffer} from 'buffer';
import axios from 'axios';

export default function App({navigate}) {
  const navigation = useNavigation();
  const baseURL = 'http://www.racsstudios.com/api/v1/login';
  const [senha, setSenha] = useState('');
  const [versenha, setVersenha] = useState(true);
  const [iconsenha, setIconsenha] = useState(require('../../images/eye1.png'));
  const [alertasenha, setAlertasenha] = useState('');
  const [retorno, setRetorno] = useState(false);
  const [loadingResponse, setLoadingResponse] = useState(false);
  const [mostrar, setMostrar] = useState(false);
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

  const mostrarsenha = () => {
    setVersenha(!versenha);
    if (versenha == true) {
      setIconsenha(require('../../images/eye0.png'));
    } else {
      setIconsenha(require('../../images/eye1.png'));
    }
  };

  const deletarUsuario = () => {
    setMsg('');
    setImg();
    if (senha == '') {
      setAlertasenha('Insira a sua senha!');
    } else {
      axios
        .post(baseURL, {
          email: Globais.dados?.useremail,
          senha: senha,
        })
        .then(response => {
          if (response.data.retorne == true) {
            let url = 'http://www.racsstudios.com/api/v1/user/';
            let username = Globais.dados?.useremail;
            let password = response.data.token;
            let token = Buffer.from(`${username}:${password}`, 'utf8').toString(
              'base64',
            );
            axios
              .delete(url, {headers: {Authorization: `Basic ${token}`}})
              .then(response => {
                console.log(response.data);
                if (response.data.success == true) {
                  setRetorno(true);
                  setLoadingResponse(true);
                  setImg(require('../../images/configuracao/sucesso.png'));
                  setMsg('Sua conta foi excluida!\nAté breve...');
                  setTimeout(() => {
                    setLoadingResponse(false);
                  }, 1500);
                }
              })
              .catch(error => {
                setImg(require('../../images/configuracao/dangericon.png'));
                setMsg(
                  'Houve um problema ao tentar excluir sua conta.\nTente novamente.',
                );
                setTimeout(() => {
                  setLoadingResponse(false);
                }, 1500);
                console.log(error.data);
              });
          }

          if (response.data.retorno == 'error') {
            setAlertasenha('Senha inválida!');
          }
          console.log(response.data);
        })
        .catch(error => {
          //   console.log(error.data)
        });
    }
  };
  return (
    <View style={estilos.container}>
      <Header goingback={true} space={true} />
      <View style={{paddingHorizontal: 30}}>
        <Text style={estilos.h1}>Configurações</Text>
        <Text style={estilos.txt}>Ajuste suas configurações.</Text>
      </View>

      <View style={{flex: 1, paddingHorizontal: 30, marginTop: 30}}>
        <View style={{flexDirection: 'row', justifyContent: 'center'}}>
          <View style={{flex: 3, justifyContent: 'center'}}>
            <Text style={estilos.txtOption}>Ativar localização</Text>
          </View>
          <View style={{flex: 1, padding: 15}}>
            <SwitchBtn
              tipo={'ativaLocalizacao'}
              valor={Globais.dados?.userativalocalizacao}
            />
          </View>
        </View>
      </View>
      {Globais?.dados ? (
        <View style={estilos.containerBtn}>
          <TouchableOpacity
            style={[estilos.btn, {backgroundColor: '#ff3434'}]}
            onPress={() => {
              optionBtn('deletar');
            }}>
            <Text
              style={{
                fontSize: 24,
                fontFamily: 'Poppins-Regular',
                color: '#fff',
                padding: 5,
                letterSpacing: 2,
              }}>
              Deletar Conta
            </Text>
          </TouchableOpacity>
        </View>
      ) : (
        <View style={estilos.containerBtn}>
          <TouchableOpacity
            style={[estilos.btn, {backgroundColor: '#C980A3'}]}
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
            style={[estilos.btn, {backgroundColor: '#920049'}]}
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
                  style={[estilos.txt, {paddingVertical: 10, fontSize: 14}]}>
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
        <Modal visible={deletar} transparent={true}>
          <View
            style={{
              flex: 1,
              alignItems: 'center',
              backgroundColor: 'rgba(0, 0 , 0, 0.8)',
            }}>
            <View style={[estilos.containerModal, {height: 375, top: '20%'}]}>
              <View style={{alignItems: 'flex-end'}}>
                <TouchableOpacity
                  onPress={() => {
                    setDeletar(false);
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
                  style={[estilos.txt, {paddingVertical: 10, fontSize: 14}]}>
                  Confirme sua senha para DELETAR.
                </Text>

                <View
                  style={{
                    paddingHorizontal: 20,
                    flexDirection: 'row',
                    alignItems: 'center',
                    marginBottom: 40,
                  }}>
                  <View style={estilos.containerInput}>
                    <TextInput
                      placeholder={'Senha'}
                      placeholderTextColor={'#8E8E8E'}
                      secureTextEntry={versenha}
                      value={senha}
                      onChangeText={value => {
                        setSenha(value);
                        setAlertasenha('');
                      }}
                      style={estilos.input}></TextInput>
                    <Text style={{color: 'red', fontSize: 15, padding: 5}}>
                      {alertasenha}
                    </Text>
                  </View>
                  <TouchableOpacity
                    style={{
                      position: 'absolute',
                      alignSelf: 'center',
                      right: 30,
                      padding: 10,
                    }}
                    onPress={mostrarsenha}>
                    <Image style={estilos.img} source={iconsenha} />
                  </TouchableOpacity>
                </View>

                <TouchableOpacity
                  style={[
                    estilos.btnBg,
                    {backgroundColor: '#FF3434', width: '50%'},
                  ]}
                  onPress={deletarUsuario}>
                  <Text
                    style={[
                      estilos.txtModal,
                      {
                        color: '#D8D8D8',
                        textAlignVertical: 'center',
                        fontFamily: 'Roboto-Bold',
                      },
                    ]}>
                    DELETAR
                  </Text>
                </TouchableOpacity>
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
  },
  h1: {
    fontSize: 24,
    fontFamily: 'Poppins-Regular',
    color: '#910046',
  },
  txt: {
    bottom: 5,
    fontSize: 12,
    fontFamily: 'Poppins-Regular',
    color: '#414141',
  },
  txtOption: {
    fontSize: 16,
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
  containerBtn: {
    flex: 1,
    justifyContent: 'flex-end',
    marginTop: 30,
    alignItems: 'center',
    bottom: '6%',
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
  input: {
    width: '90%',
    height: 50,
    fontSize: 14,
    padding: 13,
    borderColor: '#E7E7E7',
    backgroundColor: '#E7E7E7',
    fontFamily: 'Poppins-Regular',
    borderRadius: 8,
    color: '#333',
  },
  containerInput: {
    width: '100%',
    height: 50,
    borderColor: '#E7E7E7',
    backgroundColor: '#E7E7E7',
    fontFamily: 'Poppins-Regular',
    borderRadius: 8,
  },
  img: {
    height: 25,
    width: 25,
    resizeMode: 'contain',
  },
});
