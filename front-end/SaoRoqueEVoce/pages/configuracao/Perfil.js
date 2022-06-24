import React, {useState} from 'react';
import {
  StyleSheet,
  Text,
  View,
  TextInput,
  TouchableOpacity,
  Image,
  Modal,
  Dimensions,
  ActivityIndicator,
} from 'react-native';
import Header from '../../componentes/Header';
import Globais from '../../componentes/Globais';
import {TextInputMask} from 'react-native-masked-text';
import AsyncStorage from '@react-native-async-storage/async-storage';
import {Buffer} from 'buffer';
import axios from 'axios';

export default function App({navigation}) {
  const baseURL = 'http://www.racsstudios.com/api/v1/user';
  const [mostrarAtualizar, setMostrarAtualizar] = useState(false);
  const [mostrarAlterarSenha, setMostrarAlterarSenha] = useState(false);
  const [nome, setNome] = useState(Globais.dados?.usernome);
  const [sobrenome, setSobrenome] = useState(Globais.dados?.usersobrenome);
  const [dataNascimento, setDataNascimento] = useState(
    Globais.dados?.usernascimento,
  );
  const [confirmacao, setConfirmacao] = useState();
  const [erronome, setErronome] = useState('');
  const [errosobrenome, setErrosobrenome] = useState('');
  const [errodatanascimento, setErrodatanascimento] = useState('');
  const [loadingResponse, setLoadingResponse] = useState(false);
  const [retorno, setRetorno] = useState(false);
  const [msg, setMsg] = useState(false);
  const [img, setImg] = useState();
  const [nomeStorage, setNomeStorage] = useState(Globais.dados?.usernome);
  const [sobrenomeStorage, setSobrenomeStorage] = useState(
    Globais.dados?.usersobrenome,
  );
  const [dataNascimentoStorage, setNascimentoStorage] = useState(
    Globais.dados?.usernascimento,
  );
  const [usernome, setUsernome] = useState(null);
  const [usersobrenome, setUsersobrenome] = useState(null);
  const [usernascimento, setUsernascimento] = useState(null);
  const [usertoken, setUsertoken] = useState(Globais.dados?.usertoken);
  const [useremail, setUseremail] = useState(Globais.dados?.useremail);
  const [useridusuario, setUseridusuario] = useState(
    Globais.dados?.useridusuario,
  );
  const [userdicasrestaurante, setUserdicasrestaurante] = useState(
    Globais.dados?.userdicasrestaurante,
  );
  const [userdicasturismo, setUserdicasturismo] = useState(
    Globais.dados?.userdicasturismo,
  );
  const [userdicashospedagem, setUserdicashospedagem] = useState(
    Globais.dados?.userdicashospedagem,
  );
  const [userativalocalizacao, setUserativalocalizacao] = useState(
    Globais.dados?.userativalocalizacao,
  );
  const [useralertanovidade, setUseralertanovidade] = useState(
    Globais.dados?.useralertanovidade,
  );
  const [useralertaevento, setUseralertaevento] = useState(
    Globais.dados?.useralertaevento,
  );
  const [versenha, setVersenha] = useState(true);
  const [senha, setSenha] = useState('');
  const [novasenha, setNovaSenha] = useState('');
  const [confirmaSenha, setConfirmaSenha] = useState('');
  const [iconsenha, setIconsenha] = useState(require('../../images/eye1.png'));
  const [alertasenha, setAlertasenha] = useState('');
  const [erroSenha, setErroSenha] = useState('');

  const mostrarsenha = () => {
    setVersenha(!versenha);
    if (versenha == true) {
      setIconsenha(require('../../images/eye0.png'));
    } else {
      setIconsenha(require('../../images/eye1.png'));
    }
  };

  const update = async () => {
    setRetorno(true);
    setLoadingResponse(true);
    let username = Globais.dados?.useremail;
    let password = Globais.dados?.usertoken;
    let auth = Buffer.from(`${username}:${password}`, 'utf8').toString(
      'base64',
    );
    let body = {
      nomeUsuario: nome,
      sobreNome: sobrenome,
      dataNascimento: dataNascimento,
    };
    await axios
      .put(baseURL, body, {headers: {Authorization: `Basic ${auth}`}})
      .then(response => {
        console.log('entrou sucesso');
        console.log(response.data);
        setConfirmacao(response.data);
        setImg(require('../../images/configuracao/sucesso.png'));
        setMsg('Perfil atualizado com sucesso!');
        setTimeout(() => {
          setLoadingResponse(false);
        }, 1500);
        setNomeStorage(nome);
        setSobrenomeStorage(sobrenome);
        setNascimentoStorage(dataNascimento);
      })
      .catch(error => {
        console.log('entrou erro');
        setImg(require('../../images/configuracao/dangericon.png'));
        setMsg(
          'Houve um problema ao tentar atualizar suas informações!\nTente novamente.',
        );
        setTimeout(() => {
          setLoadingResponse(false);
        }, 1500);
      });
  };

  const salvarStorage = () => {
    setUsernome(
      confirmacao?.nomeUsuario[0].toUpperCase() +
        confirmacao?.nomeUsuario.substr(1),
    );
    setUsersobrenome(
      confirmacao?.sobreNome[0].toUpperCase() +
        confirmacao?.sobreNome.substr(1),
    );
    setUsernascimento(confirmacao?.dataNascimento);
  };

  if (
    usernome &&
    usernome != null &&
    usersobrenome != null &&
    usernascimento != null
  ) {
    const usuario = {
      usernome,
      usersobrenome,
      usernascimento,
      usertoken,
      useremail,
      useridusuario,
      userdicasrestaurante,
      userdicasturismo,
      userdicashospedagem,
      userativalocalizacao,
      useralertanovidade,
      useralertaevento,
    };
    try {
      const jsonValue = JSON.stringify(usuario);
      AsyncStorage.setItem('usuario', jsonValue);
    } catch (e) {
      console.log(e);
    }
  }

  const validar = () => {
    let error = false;
    const se = new RegExp(
      '^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})',
    );

    if (!se.test(novasenha)) {
      setErroSenha(
        'Mínimo 8 caractéres contendo pelo menos 1: minúsculo, maiúsculo, numérico, especial',
      );
      error = true;
    }
    if (novasenha !== confirmaSenha) {
      setErroSenha('As senhas não coincidem!');
      error = true;
    }
    if (novasenha === '') {
      setErroSenha('Insira sua senha nova senha!');
      error = true;
    }
    if (senha === '') {
      setAlertasenha('Insira sua senha atual!');
      error = true;
    }
    return !error;
  };

  const alterarSenha = () => {
    let validarConexao = true;
    setMsg('');
    if (validar()) {
      axios
        .post('http://www.racsstudios.com/api/v1/login', {
          email: Globais.dados.useremail,
          senha: senha,
        })
        .then(response => {
          validarConexao = false;
          if (response.data.retorno == 'error') {
            setAlertasenha('Senha inválida!');
          } else {
            setRetorno(true);
            setLoadingResponse(true);
            let url = 'http://www.racsstudios.com/api/v1/setuser';
            let username = useremail;
            let password = response.data.token;
            const auth = Buffer.from(
              `${username}:${password}`,
              'utf8',
            ).toString('base64');
            let body = {
              email: useremail,
              token: password,
              novaSenha: novasenha,
            };
            console.log(password);
            axios
              .put(url, body, {headers: {Authorization: `Basic ${auth}`}})
              .then(response => {
                console.log(response.data);

                setMsg('Sua senha foi alterada com sucesso!');
                setImg(require('../../images/configuracao/sucesso.png'));
                setConfirmacao(response.data);
                setTimeout(() => {
                  setLoadingResponse(false);
                }, 2000);
                setUsertoken(password);
              })
              .catch(error => {
                console.log(error.data);
                validarConexao = false;
                console.log(validarConexao);
                if (msg == '') {
                  setImg(require('../../images/configuracao/dangericon.png'));
                  setMsg('Token inválido, tente novamente.');
                }
                setTimeout(() => {
                  setLoadingResponse(false);
                }, 2000);
              });
          }
        })
        .catch(error => {
          //   console.log(error.data)
        });

      setTimeout(() => {
        if (validarConexao == true) {
          console.log(validarConexao);
          setLoadingResponse(false);
          setImg(require('../../images/configuracao/dangericon.png'));
          setMsg('Houve um erro.\nVerifique sua internet\ne tente novamente.');
        }
      }, 6000);
    }
  };

  return (
    <View style={estilos.container}>
      <Header goingback={true} space={true} />
      <View style={{paddingHorizontal: 30}}>
        <Text style={estilos.h1}>Perfil</Text>
        <Text style={estilos.txt}>Atualize suas informações.</Text>
      </View>

      {nomeStorage ? (
        <View style={{flex: 2, paddingHorizontal: 30}}>
          <View>
            <View style={{marginTop: 15}}>
              <Text style={estilos.miniText}>Nome</Text>
              <TextInput
                editable={false}
                placeholder={nomeStorage}
                placeholderTextColor={'#414141'}
                style={estilos.input}></TextInput>
            </View>
            <View style={{marginTop: 15}}>
              <Text style={estilos.miniText}>Sobrenome</Text>
              <TextInput
                editable={false}
                placeholder={sobrenomeStorage}
                placeholderTextColor={'#414141'}
                style={estilos.input}></TextInput>
            </View>
            <View style={{marginTop: 15}}>
              <Text style={estilos.miniText}>Data de Nascimento</Text>
              <TextInput
                editable={false}
                placeholder={dataNascimentoStorage}
                placeholderTextColor={'#414141'}
                style={estilos.input}></TextInput>
            </View>
            <View style={{marginTop: 15}}>
              <Text style={estilos.miniText}>E-mail</Text>
              <TextInput
                editable={false}
                placeholder={useremail}
                placeholderTextColor={'#414141'}
                style={estilos.input}></TextInput>
            </View>
          </View>
          <View style={estilos.containerBtn}>
            <TouchableOpacity
              style={[estilos.btn, {backgroundColor: '#C980A3'}]}
              onPress={() => setMostrarAlterarSenha(true)}>
              <Text
                style={{
                  fontSize: 24,
                  fontFamily: 'Poppins-Regular',
                  color: '#910046',
                  padding: 5,
                  letterSpacing: 2,
                }}>
                Alterar senha
              </Text>
            </TouchableOpacity>
            <TouchableOpacity
              style={estilos.btn}
              onPress={() => setMostrarAtualizar(true)}>
              <Text
                style={{
                  fontSize: 24,
                  fontFamily: 'Poppins-Regular',
                  color: '#CDCDCD',
                  padding: 5,
                  letterSpacing: 2,
                }}>
                Atualizar
              </Text>
            </TouchableOpacity>
          </View>
        </View>
      ) : (
        <View>
          <View>
            <View style={{marginHorizontal: 30, marginVertical: 20}}>
              <View style={{alignItems: 'center'}}>
                <Image
                  style={{width: 50, height: 50}}
                  source={require('../../images/paginadetalhes/warning-purple.png')}
                />
                <Text
                  style={{
                    fontFamily: 'Poppins-Regular',
                    fontSize: 16,
                    color: '#000',
                    textAlign: 'center',
                    marginTop: 15,
                  }}>
                  Entre ou cadastre-se para gerenciar o seu perfil!
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
                  onPress={() => navigation.navigate('Login')}>
                  <Text style={estilos.txtBtn2}>ENTRAR</Text>
                </TouchableOpacity>
                <TouchableOpacity
                  style={[estilos.btn2, {backgroundColor: '#920046'}]}
                  onPress={() => navigation.navigate('Cadastro')}>
                  <Text style={[estilos.txtBtn2, {color: 'white'}]}>
                    CADASTRAR
                  </Text>
                </TouchableOpacity>
              </View>
            </View>
          </View>
        </View>
      )}

      <View>
        <Modal visible={mostrarAtualizar} transparent={true}>
          <View
            style={{
              flex: 1,
              alignItems: 'center',
              backgroundColor: 'rgba(0, 0 , 0, 0.8)',
              justifyContent: 'center',
            }}>
            <View style={estilos.containerModal}>
              <View style={{alignItems: 'flex-end'}}>
                <TouchableOpacity
                  onPress={() => {
                    setMostrarAtualizar(false);
                  }}>
                  <Image
                    style={{height: 25, width: 25}}
                    source={require('../../images/configuracao/close.png')}
                  />
                </TouchableOpacity>
              </View>
              <View>
                <View style={{alignItems: 'center'}}>
                  <Text
                    style={[
                      estilos.txt,
                      {
                        paddingVertical: 5,
                        fontSize: 16,
                        paddingLeft: 5,
                        top: 3,
                      },
                    ]}>
                    Atualize suas informações
                  </Text>
                </View>
                <View style={{paddingHorizontal: 10}}>
                  <View style={{marginTop: 0}}>
                    <Text style={estilos.miniText}>Nome</Text>
                    <TextInput
                      value={nome}
                      onChangeText={setNome}
                      placeholder={nomeStorage}
                      placeholderTextColor={'#414141'}
                      style={estilos.input}></TextInput>
                  </View>
                  <View style={{marginTop: 15}}>
                    <Text style={estilos.miniText}>Sobrenome</Text>
                    <TextInput
                      value={sobrenome}
                      onChangeText={setSobrenome}
                      placeholder={sobrenomeStorage}
                      placeholderTextColor={'#414141'}
                      style={estilos.input}></TextInput>
                  </View>
                  <View style={{marginVertical: 15}}>
                    <Text style={estilos.miniText}>Data de Nascimento</Text>
                    <TextInputMask
                      type={'custom'}
                      options={{mask: '99/99/9999'}}
                      value={dataNascimento}
                      onChangeText={value => {
                        setDataNascimento(value);
                        setErrodatanascimento('');
                      }}
                      placeholder={dataNascimentoStorage}
                      keyboardType="numeric"
                      placeholderTextColor={'#414141'}
                      style={estilos.input}
                    />
                  </View>
                </View>
              </View>
              <View
                style={{alignItems: 'center', marginTop: 25, marginBottom: 10}}>
                <View style={{flexDirection: 'row', padding: 0}}>
                  <TouchableOpacity
                    style={[estilos.btnBg, {backgroundColor: '#920046'}]}
                    onPress={() => {
                      update();
                    }}>
                    <Text style={[estilos.txtModal, {color: '#FFF'}]}>
                      Atualizar dados
                    </Text>
                  </TouchableOpacity>
                </View>
              </View>
            </View>
          </View>
        </Modal>
      </View>

      <View>
        <Modal visible={mostrarAlterarSenha} transparent={true}>
          <View
            style={{
              flex: 1,
              alignItems: 'center',
              backgroundColor: 'rgba(0, 0 , 0, 0.8)',
              justifyContent: 'center',
            }}>
            <View style={estilos.containerModal}>
              <View style={{alignItems: 'flex-end'}}>
                <TouchableOpacity
                  onPress={() => {
                    setAlertasenha('');
                    setErroSenha('');
                    setSenha('');
                    setNovaSenha('');
                    setConfirmaSenha('');
                    setMostrarAlterarSenha(false);
                  }}>
                  <Image
                    style={{height: 25, width: 25}}
                    source={require('../../images/configuracao/close.png')}
                  />
                </TouchableOpacity>
              </View>
              <View>
                <View style={{alignItems: 'center'}}>
                  <Text
                    style={[
                      estilos.txt,
                      {
                        paddingVertical: 5,
                        fontSize: 16,
                        paddingLeft: 5,
                        top: 3,
                      },
                    ]}>
                    Altere a sua senha
                  </Text>
                </View>
                <View
                  style={{
                    paddingHorizontal: 20,
                    flexDirection: 'row',
                    alignItems: 'center',
                    marginBottom: 10,
                    marginTop: 20,
                  }}>
                  <View style={estilos.containerInput}>
                    <TextInput
                      placeholder={'Senha antiga'}
                      placeholderTextColor={'#8E8E8E'}
                      secureTextEntry={versenha}
                      value={senha}
                      onChangeText={value => {
                        setSenha(value);
                        setAlertasenha('');
                      }}
                      style={estilos.input2}></TextInput>
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
                <View style={{flexDirection: 'row'}}>
                  <Text
                    style={{
                      color: 'red',
                      fontSize: 14,
                      bottom: 10,
                      marginLeft: 20,
                      height: 20,
                    }}>
                    {alertasenha}
                  </Text>
                  <TouchableOpacity
                    onPress={() => {
                      navigation.navigate('EsqueciSenha');
                      setTimeout(() => {
                        setMostrarAlterarSenha(false);
                      }, 1000);
                    }}>
                    <Text
                      style={{
                        color: 'blue',
                        fontSize: 14,
                        bottom: 10,
                        marginLeft: 5,
                        height: 20,
                      }}>
                      Esqueceu sua senha?
                    </Text>
                  </TouchableOpacity>
                </View>
                <View
                  style={{
                    paddingHorizontal: 20,
                    flexDirection: 'row',
                    alignItems: 'center',
                    marginBottom: 10,
                    marginTop: 20,
                  }}>
                  <View style={estilos.containerInput}>
                    <TextInput
                      placeholder={'Nova senha'}
                      placeholderTextColor={'#8E8E8E'}
                      secureTextEntry={versenha}
                      value={novasenha}
                      onChangeText={value => {
                        setNovaSenha(value);
                        setErroSenha('');
                      }}
                      style={estilos.input2}></TextInput>
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
                <View
                  style={{
                    paddingHorizontal: 20,
                    flexDirection: 'row',
                    alignItems: 'center',
                    marginBottom: 0,
                  }}>
                  <View style={estilos.containerInput}>
                    <TextInput
                      placeholder={'Confirmar nova senha'}
                      placeholderTextColor={'#8E8E8E'}
                      secureTextEntry={versenha}
                      value={confirmaSenha}
                      onChangeText={value => {
                        setConfirmaSenha(value);
                        setErroSenha('');
                      }}
                      style={estilos.input2}></TextInput>
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
                <Text
                  style={{
                    color: 'red',
                    fontSize: 14,
                    marginLeft: 20,
                    height: 35,
                  }}>
                  {erroSenha}
                </Text>
              </View>
              <View
                style={{alignItems: 'center', marginTop: 25, marginBottom: 10}}>
                <View style={{flexDirection: 'row', padding: 0}}>
                  <TouchableOpacity
                    style={[estilos.btnBg, {backgroundColor: '#920046'}]}
                    onPress={() => {
                      alterarSenha();
                    }}>
                    <Text style={[estilos.txtModal, {color: '#FFF'}]}>
                      Alterar senha
                    </Text>
                  </TouchableOpacity>
                </View>
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
              justifyContent: 'center',
            }}>
            <View style={[estilos.containerModal, {height: 230, bottom: '5%'}]}>
              <View style={{alignItems: 'flex-end'}}>
                <TouchableOpacity
                  onPress={() => {
                    salvarStorage();
                    setRetorno(false);
                    setMostrarAtualizar(false);
                    setMostrarAlterarSenha(false);
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
                        estilos.txtModalRetorno,
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
  miniText: {
    color: '#8E8E8E',
    fontSize: 12,
    top: 10,
    marginLeft: 5,
  },
  input: {
    fontSize: 18,
    borderBottomWidth: 1,
    borderColor: '#C4C4C4',
    paddingBottom: -10,
    color: '#000',
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
    alignItems: 'center',
    marginBottom: '15%',
  },
  btn2: {
    backgroundColor: 'rgba(146, 0 , 70, 0.28)',
    borderRadius: 5,
    borderColor: '#920046',
    borderWidth: 1,
    height: 45,
    width: 140,
  },
  txtBtn2: {
    flex: 1,
    fontSize: 17,
    fontFamily: 'Poppins-SemiBold',
    textAlign: 'center',
    textAlignVertical: 'center',
    color: '#920046',
    paddingTop: 5,
    letterSpacing: 1,
  },
  btnBg: {
    width: 250,
    height: 45,
    backgroundColor: '#CCC',
    borderRadius: 34,
    alignItems: 'center',
    justifyContent: 'center',
    marginHorizontal: 15,
  },
  txtModal: {
    fontSize: 24,
    fontFamily: 'Poppins-Regular',
    color: '#000',
  },
  txtModalRetorno: {
    fontSize: 16,
    fontFamily: 'Poppins-Regular',
    color: '#000',
  },
  cardBody: {
    alignItems: 'center',
    marginVertical: 15,
    backgroundColor: '#F4F4F4',
    marginHorizontal: 20,
    borderRadius: 15,
    paddingVertical: 15,
    elevation: 5,
    shadowColor: '#000',
    shadowOpacity: 1,
    shadowOffset: {
      width: 2,
      height: 3,
    },
  },
  containerModal: {
    bottom: '10%',
    width: 350,
    padding: 20,
    borderRadius: 30,
    backgroundColor: '#fff',
    justifyContent: 'center',
    elevation: 5,
    shadowColor: '#000',
    shadowOpacity: 1,
    shadowOffset: {
      width: 2,
      height: 3,
    },
  },
  img: {
    height: 25,
    width: 25,
    resizeMode: 'contain',
  },
  input2: {
    fontSize: 16,
    color: '#910046',
  },
  containerInput: {
    width: '100%',
    height: 50,
    borderColor: '#E7E7E7',
    backgroundColor: '#E7E7E7',
    fontFamily: 'Poppins-Regular',
    borderRadius: 8,
    paddingLeft: 10,
  },
});
