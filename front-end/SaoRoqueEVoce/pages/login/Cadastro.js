import React, {useState, useEffect, useRef} from 'react';
import {
  StyleSheet,
  Text,
  View,
  TouchableOpacity,
  TextInput,
  Modal,
  Image,
  KeyboardAvoidingView,
  Platform,
  ScrollView,
  ActivityIndicator,
} from 'react-native';
import CheckBox from '@react-native-community/checkbox';
import Header from '../../componentes/Header';
import AsyncStorage from '@react-native-async-storage/async-storage';
import {TextInputMask} from 'react-native-masked-text';
import CountDown from 'react-native-countdown-component';
import {Buffer} from 'buffer';
import axios from 'axios';

export default function App({navigation, route}) {
  const baseURL = 'http://www.racsstudios.com/api/v1/user/';
  const [isSelected, setSelection] = useState(false);
  const [nome, setNome] = useState('');
  const [sobrenome, setSobrenome] = useState();
  const [dataNascimento, setDataNascimento] = useState('');
  const [email, setEmail] = useState('');
  const [senha, setSenha] = useState('');
  const [confirmarsenha, setConfirmarsenha] = useState('');
  const [erronome, setErronome] = useState('');
  const [errosobrenome, setErrosobrenome] = useState('');
  const [errodatanascimento, setErrodatanascimento] = useState('');
  const [erroemail, setErroemail] = useState('');
  const [errosenha, setErrosenha] = useState('');
  const [erroselect, setErroselect] = useState('');
  const [inputnome, setInputnome] = useState('');
  const [inputsobrenome, setInputsobrenome] = useState('');
  const [inputdatanascimento, setInputdatanascimento] = useState('');
  const [inputemail, setInputemail] = useState('');
  const [inputsenha, setInputsenha] = useState('');
  const [inputconfirmarsenha, setInputconfirmarsenha] = useState('');
  const [mostrar, setMostrar] = useState(false);
  const [mostrarindicator, setMostrarindicator] = useState(false);
  const [usernome, setUsernome] = useState(null);
  const [usersobrenome, setUsersobrenome] = useState(null);
  const [usertoken, setUsertoken] = useState(null);
  const [usernascimento, setUsernascimento] = useState(null);
  const [useremail, setUseremail] = useState(null);
  const [useridusuario, setUseridusuario] = useState(null);
  const [userdicasrestaurante, setUserdicasrestaurante] = useState(null);
  const [userdicasturismo, setUserdicasturismo] = useState(null);
  const [userdicashospedagem, setUserdicashospedagem] = useState(null);
  const [userativalocalizacao, setUserativalocalizacao] = useState(null);
  const [useralertanovidade, setUseralertanovidade] = useState(null);
  const [useralertaevento, setUseralertaevento] = useState(null);
  const [confirmacao, setConfirmacao] = useState();
  const [versenha, setVersenha] = useState(true);
  const [iconsenha, setIconsenha] = useState(require('../../images/eye1.png'));
  const [mostrarerro, setMostrarerro] = useState(false);
  const [msg, setMsg] = useState('');
  const [popuptoken, setPopuptoken] = useState(false);
  const [loadingResponse, setLoadingResponse] = useState(false);
  const [pin1, setPin1] = useState('');
  const [pin2, setPin2] = useState('');
  const [pin3, setPin3] = useState('');
  const [pin4, setPin4] = useState('');
  const pin1Ref = useRef(null);
  const pin2Ref = useRef(null);
  const pin3Ref = useRef(null);
  const pin4Ref = useRef(null);
  const [enviado, setEnviado] = useState(false);
  const [tempo, setTempo] = useState(false);
  const [avisomsg, setAvisomsg] = useState('');
  const [dados, setDados] = useState([]);


  useEffect(() => {
    loadApi();
  }, []);

  async function loadApi() {
     const response = await axios.get(`http://www.racsstudios.com/api/v1`);
    setDados(response.data);
  }

  const validar = () => {
    let error = false;
    const re =
      /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    const se = new RegExp(
      '^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})',
    );

    setErronome('');
    setErrosobrenome('');
    setErrodatanascimento('');
    setErroemail('');
    setErrosenha('');

    if (nome == '') {
      setErronome('Preencha o seu nome!');
      error = true;
    }
    if (sobrenome == null || sobrenome == '') {
      setErrosobrenome('Preencha o seu sobrenome!');
      error = true;
    }
    if (dataNascimento == '') {
      setErrodatanascimento('Preencha a sua data de nascimento!');
      error = true;
    }
    if (!re.test(String(email).toLocaleLowerCase())) {
      setErroemail('Insira um e-mail válido!');
      error = true;
    }
    if (email == '') {
      setErroemail('Preencha o seu email!');
      error = true;
    }
    if (!se.test(senha)) {
      setErrosenha(
        'Mínimo 8 caractéres contendo pelo menos 1: minúsculo, maiúsculo, numérico, especial',
      );
      error = true;
    }
    if (senha !== confirmarsenha) {
      setErrosenha('As senhas não coincidem!');
      error = true;
    }
    if (senha == '') {
      setErrosenha('Preencha a sua senha!');
      error = true;
    }
    if (isSelected == false) {
      setErroselect(
        'Selecione que você leu e concorda com os \nTermos de Uso e a Política de Privacidade',
      );
      error = true;
    }

    return !error;
  };

  const selection = () => {
    setSelection(!isSelected);
    setErroselect('');
  };

  const mostrarsenha = () => {
    setVersenha(!versenha);
    if (versenha == true) {
      setIconsenha(require('../../images/eye0.png'));
    } else {
      setIconsenha(require('../../images/eye1.png'));
    }
  };
  const criarUsuario = () => {
    let verificar = true;
    if (validar()) {
      setMostrarindicator(true);
      axios
        .post(baseURL, {
          nomeUsuario: nome,
          sobreNome: sobrenome,
          dataNascimento: dataNascimento,
          email: email,
          senha: senha,
        })
        .then(response => {
          verificar = false;
          setConfirmacao(response.data);
          setMostrarindicator(false);
          setPopuptoken(true);
        })
        .catch(error => {
          verificar = false;
          if (error.response.data?.retorno == 'error') {
            setTimeout(() => {
              setMostrarindicator(false);
              setErroemail('E-mail já cadastrado!');
            }, 1000);
          }
        });
      setTimeout(() => {
        if (verificar === true) {
          setMsg(
            'Não foi possível realizar o seu cadastro.\nVerifique sua conexão com a internet\ne tente novamente.'
          );
          setTimeout(() => {
            setMostrarindicator(false), setMostrarerro(true);
          }, 8000);
        }
      }, 3000);
    }
  };

  function verificarToken() {
    let username = email;
    let password = usertoken;
    const senhatoken = Buffer.from(`${username}:${password}`, 'utf8').toString(
      'base64',
    );
    let baseURL = 'http://www.racsstudios.com/api/v1/user/';
    let body = {
      token: usertoken,
    };
    console.log(usertoken);
    axios
      .put(baseURL, body, {headers: {Authorization: `Basic ${senhatoken}`}})
      .then(response => {
        setLoadingResponse(true);
        salvar();
        setMostrar(true);
        setTimeout(() => {
          setLoadingResponse(false);
        }, 1500);
      })
      .catch(error => {
        setLoadingResponse(true);
        setMostrarerro(true);
        setTimeout(() => {
          setLoadingResponse(false);
          setMsg('Token inválido, tente novamente.');
        }, 1500);
        console.log(error.response?.data);
      });
  }

  function enviarEmail() {
    setEnviado(true);
    setTempo(10);
    axios
      .post('http://www.racsstudios.com/api/v1/setuser', {
        newToken: email,
      })
      .then(response => {
        console.log(response.data);
      })
      .catch(error => {
        console.log(error.data);
      });
  }

  const salvar = async () => {
    console.log('entrou no salvar');
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
    console.log(usuario);
    try {
      const jsonValue = JSON.stringify(usuario);
      await AsyncStorage.setItem('usuario', jsonValue);
      console.log(jsonValue);
    } catch (e) {
      console.log(e);
    }
  };

  if (
    confirmacao?.retorno == 'success' &&
    usernome === null &&
    usertoken != null
  ) {
    console.log('entrou aqui');
    setUsernome(
      confirmacao.nomeUsuario[0].toUpperCase() +
        confirmacao.nomeUsuario.substr(1),
    );
    setUsersobrenome(
      confirmacao.sobreNome[0].toUpperCase() + confirmacao.sobreNome.substr(1),
    );
    setUseremail(confirmacao.email);
    setUseridusuario(confirmacao.idUsuario);
    setUsernascimento(confirmacao.dataNascimento);
    setUserdicasrestaurante(confirmacao.dicasRestaurantes);
    setUserdicasturismo(confirmacao.dicasPontosTuristicos);
    setUserdicashospedagem(confirmacao.dicasHospedagens);
    setUserativalocalizacao(confirmacao.ativaLocalizacao);
    setUseralertanovidade(confirmacao.alertaNovidade);
    setUseralertaevento(confirmacao.alertaEventos);
  }

  const rota = () => {
    if (route.params?.id) {
      navigation.goBack({icon: icon, tipo: tipo, id: id});
    } else {
      navigation.navigate('Index');
    }
  };

  let id = route.params?.id;
  let icon = route.params?.icon;
  let tipo = route.params?.tipo;
  let titleTermos = 'Termos de Uso';
  let titlePolitica = 'Política de Privacidade';
  let textTermos =
    'Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia, molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit, tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit, quia. Quo neque error repudiandae fuga?';
  let textPolitica = dados?.politica

  return (
    <View style={estilos.container}>
      <KeyboardAvoidingView
        behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
        keyboardVerticalOffset={-10}
        style={{flex: 3}}>
        <ScrollView style={{flex: 3}}>
          <Header space={true} />
          <View
            style={{
              paddingHorizontal: 40,
              alignItems: 'center',
              justifyContent: 'center',
            }}>
            <Text
              style={{
                fontSize: 24,
                fontFamily: 'Poppins-Regular',
                color: '#910046',
                alignSelf: 'flex-start',
              }}>
              Crie a sua conta
            </Text>
            <View style={{width: '100%', marginTop: 15, marginBottom: 25}}>
              <Text
                style={{
                  position: 'absolute',
                  top: -15,
                  color: '#8E8E8E',
                  fontFamily: 'Poppins-Regular',
                }}>
                {inputnome}
              </Text>
              <TextInput
                value={nome}
                onChangeText={value => {
                  setNome(value);
                  setErronome('');
                  setInputnome('Nome');
                }}
                placeholder="Nome"
                placeholderTextColor={'#414141'}
                style={estilos.input}></TextInput>
              <Text style={{position: 'absolute', top: 35, color: '#910046'}}>
                {erronome}
              </Text>
            </View>

            <View style={{width: '100%', marginTop: 15, marginBottom: 25}}>
              <Text
                style={{
                  position: 'absolute',
                  top: -15,
                  color: '#8E8E8E',
                  fontFamily: 'Poppins-Regular',
                }}>
                {inputsobrenome}
              </Text>
              <TextInput
                value={sobrenome}
                onChangeText={value => {
                  setSobrenome(value);
                  setErrosobrenome('');
                  setInputsobrenome('Sobrenome');
                }}
                placeholder="Sobrenome"
                placeholderTextColor={'#414141'}
                style={estilos.input}></TextInput>
              <Text style={{position: 'absolute', top: 35, color: '#910046'}}>
                {errosobrenome}
              </Text>
            </View>

            <View style={{width: '100%', marginTop: 15, marginBottom: 25}}>
              <Text
                style={{
                  position: 'absolute',
                  top: -15,
                  color: '#8E8E8E',
                  fontFamily: 'Poppins-Regular',
                }}>
                {inputdatanascimento}
              </Text>
              <TextInputMask
                type={'custom'}
                options={{mask: '99/99/9999'}}
                value={dataNascimento}
                onChangeText={value => {
                  setDataNascimento(value);
                  setErrodatanascimento('');
                  setInputdatanascimento('Dada de Nascimento');
                }}
                placeholder="Data de Nascimento"
                keyboardType="numeric"
                placeholderTextColor={'#414141'}
                style={estilos.input}
              />
              <Text style={{position: 'absolute', top: 35, color: '#910046'}}>
                {errodatanascimento}
              </Text>
            </View>

            <View style={{width: '100%', marginTop: 15, marginBottom: 25}}>
              <Text
                style={{
                  position: 'absolute',
                  top: -15,
                  color: '#8E8E8E',
                  fontFamily: 'Poppins-Regular',
                }}>
                {inputemail}
              </Text>
              <TextInput
                value={email}
                onChangeText={value => {
                  setEmail(value);
                  setErroemail('');
                  setInputemail('E-mail');
                }}
                placeholder="E-mail"
                keyboardType="email-address"
                placeholderTextColor={'#414141'}
                style={estilos.input}></TextInput>
              <Text style={{position: 'absolute', top: 35, color: '#910046'}}>
                {erroemail}
              </Text>
            </View>

            <View
              style={{
                width: '100%',
                marginTop: 15,
                marginBottom: 25,
                flexDirection: 'row',
                alignItems: 'center',
              }}>
              <View style={{width: '100%'}}>
                <Text
                  style={{
                    position: 'absolute',
                    top: -15,
                    color: '#8E8E8E',
                    fontFamily: 'Poppins-Regular',
                  }}>
                  {inputsenha}
                </Text>
                <TextInput
                  value={senha}
                  onChangeText={value => {
                    setSenha(value);
                    setErrosenha('');
                    setInputsenha('Senha');
                  }}
                  placeholder="Senha"
                  secureTextEntry={versenha}
                  placeholderTextColor={'#414141'}
                  style={estilos.input}></TextInput>
                <Text style={{position: 'absolute', top: 35, color: '#910046'}}>
                  {errosenha}
                </Text>
              </View>
              <TouchableOpacity
                style={{position: 'absolute', right: 10}}
                onPress={mostrarsenha}>
                <View style={{padding: 7}}>
                  <Image style={{width: 25, height: 25}} source={iconsenha} />
                </View>
              </TouchableOpacity>
            </View>

            <View
              style={{
                width: '100%',
                marginTop: 30,
                marginBottom: 25,
                flexDirection: 'row',
                alignItems: 'center',
              }}>
              <View style={{width: '100%'}}>
                <Text
                  style={{
                    position: 'absolute',
                    top: -15,
                    color: '#8E8E8E',
                    fontFamily: 'Poppins-Regular',
                  }}>
                  {inputconfirmarsenha}
                </Text>
                <TextInput
                  value={confirmarsenha}
                  onChangeText={value => {
                    setConfirmarsenha(value);
                    setErrosenha('');
                    setInputconfirmarsenha('Confirmar senha');
                  }}
                  placeholder="Confirmar senha"
                  secureTextEntry={versenha}
                  placeholderTextColor={'#414141'}
                  style={estilos.input}></TextInput>
                <Text style={{position: 'absolute', top: 35, color: '#910046'}}>
                  {errosenha}
                </Text>
              </View>
              <TouchableOpacity
                style={{position: 'absolute', right: 10}}
                onPress={mostrarsenha}>
                <View style={{padding: 7}}>
                  <Image style={{width: 25, height: 25}} source={iconsenha} />
                </View>
              </TouchableOpacity>
            </View>

            <View style={estilos.conteudo2}>
              <CheckBox
                value={isSelected}
                onValueChange={selection}
                style={{transform: [{scaleX: 1.5}, {scaleY: 1.5}]}}
                tintColors={{true: '#910046', false: '#910046'}}
              />
              <View
                style={{
                  flexDirection: 'row',
                  flexWrap: 'wrap',
                  paddingLeft: 10,
                }}>
                <Text style={{color: '#414141'}}>Li e concordo com os </Text>
                <TouchableOpacity
                  onPress={() =>
                    navigation.navigate('TermosPolitica', {
                      title: titleTermos,
                      text: textTermos,
                    })
                  }>
                  <Text
                    style={{textDecorationLine: 'underline', color: '#000'}}>
                    Termos de Uso
                  </Text>
                </TouchableOpacity>
                <Text style={{color: '#414141'}}> e com a </Text>
                <TouchableOpacity
                  onPress={() =>
                    navigation.navigate('TermosPolitica', {
                      title: titlePolitica,
                      text: textPolitica,
                    })
                  }>
                  <Text
                    style={{textDecorationLine: 'underline', color: '#000'}}>
                    Política de privacidade.
                  </Text>
                </TouchableOpacity>
              </View>
              <Text
                style={{
                  position: 'absolute',
                  top: 45,
                  left: 20,
                  color: '#910046',
                }}>
                {erroselect}
              </Text>
            </View>
          </View>
        </ScrollView>
      </KeyboardAvoidingView>

      <View style={{flex: 1, alignItems: 'center', justifyContent: 'center'}}>
        <TouchableOpacity style={estilos.btn} onPress={criarUsuario}>
          <Text
            style={{
              fontSize: 24,
              fontFamily: 'Poppins-Regular',
              color: '#fff',
              paddingTop: 5,
            }}>
            Cadastrar
          </Text>
        </TouchableOpacity>
        <TouchableOpacity
          style={estilos.btn2}
          onPress={() => navigation.goBack({icon: icon, tipo: tipo, id: id})}>
          <Text
            style={{
              fontSize: 24,
              fontFamily: 'Poppins-Regular',
              color: '#910046',
              paddingTop: 5,
            }}>
            Cancelar
          </Text>
        </TouchableOpacity>
      </View>

      <View>
        <Modal visible={mostrar} transparent={true}>
          <View
            style={{
              flex: 1,
              alignItems: 'center',
              backgroundColor: 'rgba(0, 0 , 0, 0.8)',
            }}>
            <View style={estilos.containerModal}>
              <View style={{alignItems: 'flex-end'}}>
                <TouchableOpacity onPress={rota}>
                  <Image
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
                      marginBottom: 75,
                      alignItems: 'center',
                      justifyContent: 'center',
                    }}>
                    <ActivityIndicator size={75} color="#910046" />
                  </View>
                ) : (
                  <View
                    style={{alignItems: 'center', justifyContent: 'center'}}>
                    <Image
                      source={require('../../images/configuracao/sucesso.png')}
                    />
                    <Text
                      style={[
                        estilos.txtModal,
                        {textAlign: 'center', paddingVertical: 15},
                      ]}>
                      Sua conta foi criada e ativada com sucesso!
                    </Text>
                  </View>
                )}
              </View>
            </View>
          </View>
        </Modal>
      </View>

      <View>
        <Modal visible={mostrarerro} transparent={true}>
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
                    setMostrarerro(false);
                  }}>
                  <Image
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
                      marginBottom: 75,
                      alignItems: 'center',
                      justifyContent: 'center',
                    }}>
                    <ActivityIndicator size={75} color="#910046" />
                  </View>
                ) : (
                  <View
                    style={{
                      flex: 1,
                      alignItems: 'center',
                      justifyContent: 'center',
                    }}>
                    <Image
                      style={{width: 50, height: 50}}
                      source={require('../../images/configuracao/dangericon.png')}
                    />
                    <Text
                      style={[
                        estilos.txtModal,
                        {paddingVertical: 5, fontSize: 14, textAlign: 'center'},
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
      <View>
        <Modal visible={popuptoken} transparent={true}>
          <View
            style={{
              flex: 1,
              alignItems: 'center',
              backgroundColor: 'rgba(0, 0 , 0, 0.8)',
            }}>
            <View style={[estilos.containerModal, {height: 500, top: '15%'}]}>
              <View style={{flex: 1, alignItems: 'center'}}>
                <Image
                  style={{width: 50, height: 50}}
                  source={require('../../images/configuracao/dangericon.png')}
                />
                <Text
                  style={[
                    estilos.txtModal,
                    {
                      fontSize: 22,
                      textAlign: 'center',
                      fontFamily: 'Poppins-Bold',
                    },
                  ]}>
                  Confirme a sua conta!
                </Text>
                <Text
                  style={[
                    estilos.txtModal,
                    {
                      fontSize: 14,
                      textAlign: 'center',
                      marginTop: -10,
                      color: '#414141',
                    },
                  ]}>
                  Insira o Token que foi enviado para:
                </Text>
                <Text
                  style={[
                    estilos.txtModal,
                    {
                      fontFamily: 'Roboto-Bold',
                      fontSize: 15,
                      textAlign: 'center',
                      marginBottom: 10,
                    },
                  ]}>
                  {email}
                </Text>
                <Text
                  style={[
                    estilos.txtModal,
                    {
                      fontSize: 12,
                      textAlign: 'center',
                      marginBottom: 5,
                      color: '#414141',
                    },
                  ]}>
                  Dica: verifique sua caixa de Spam
                </Text>
                <View style={{flexDirection: 'row'}}>
                  <TextInput
                    style={estilos.inputToken}
                    onFocus={() => {
                      setPin1('');
                      setPin2('');
                      setPin3('');
                      setPin4('');
                    }}
                    ref={pin1Ref}
                    value={pin1}
                    keyboardType={'number-pad'}
                    maxLength={1}
                    onChangeText={pin1 => {
                      setPin1(pin1);
                      if (pin1 != '') {
                        pin2Ref.current?.focus();
                      }
                    }}
                  />
                  <TextInput
                    style={estilos.inputToken}
                    onFocus={() => {
                      setPin2('');
                      setPin3('');
                      setPin4('');
                    }}
                    ref={pin2Ref}
                    value={pin2}
                    keyboardType={'number-pad'}
                    maxLength={1}
                    onChangeText={pin2 => {
                      setPin2(pin2);
                      if (pin2 != '') {
                        pin3Ref.current?.focus();
                      }
                    }}
                  />
                  <TextInput
                    style={estilos.inputToken}
                    onFocus={() => {
                      setPin3('');
                      setPin4('');
                    }}
                    ref={pin3Ref}
                    value={pin3}
                    keyboardType={'number-pad'}
                    maxLength={1}
                    onChangeText={pin3 => {
                      setPin3(pin3);
                      if (pin3 != '') {
                        pin4Ref.current?.focus();
                      }
                    }}
                  />
                  <TextInput
                    style={estilos.inputToken}
                    onFocus={() => {
                      setPin4('');
                    }}
                    ref={pin4Ref}
                    value={pin4}
                    keyboardType={'number-pad'}
                    maxLength={1}
                    onChangeText={pin4 => {
                      setPin4(pin4);
                      setUsertoken(
                        String(pin1) +
                          String(pin2) +
                          String(pin3) +
                          String(pin4),
                      );
                    }}
                  />
                </View>
                <View style={{flexDirection: 'row', alignItems: 'center'}}>
                  <Text
                    style={[
                      estilos.txtModal,
                      {
                        fontSize: 13,
                        textAlign: 'center',
                        marginBottom: 5,
                        color: '#414141',
                      },
                    ]}>
                    Não recebeu o e-mail?{' '}
                  </Text>
                  {!enviado ? (
                    <TouchableOpacity onPress={enviarEmail}>
                      <Text
                        style={[
                          estilos.txtModal,
                          {
                            fontSize: 13,
                            fontFamily: 'Poppins-Bold',
                            textAlign: 'center',
                            marginBottom: 5,
                            color: '#000',
                            padding: 5,
                          },
                        ]}>
                        Enviar novamente
                      </Text>
                    </TouchableOpacity>
                  ) : (
                    <TouchableOpacity
                      onPress={() => {
                        setAvisomsg('Aguarde para solicitar um novo código');
                        setTimeout(() => {
                          setAvisomsg('');
                        }, 5000);
                      }}>
                      <Text
                        style={[
                          estilos.txtModal,
                          {
                            fontSize: 13,
                            fontFamily: 'Poppins-Bold',
                            textAlign: 'center',
                            marginBottom: 5,
                            color: '#999',
                            padding: 5,
                          },
                        ]}>
                        Enviar novamente
                      </Text>
                    </TouchableOpacity>
                  )}
                </View>
                {enviado ? (
                  <View style={{height: 30}}>
                    <CountDown
                      size={10}
                      until={tempo}
                      onFinish={() => setEnviado(false)}
                      digitStyle={{
                        backgroundColor: '#999',
                        borderColor: '#1CC625',
                      }}
                      digitTxtStyle={{color: '#fff', fontSize: 15}}
                      separatorStyle={{color: '#000'}}
                      timeToShow={['M', 'S']}
                      timeLabels={{m: null, s: null}}
                      showSeparator={true}
                      onPress={() => {
                        setAvisomsg('Aguarde para enviar novamente!');
                        setTimeout(() => {
                          setAvisomsg('');
                        }, 5000);
                      }}
                    />
                    <Text
                      style={{
                        fontFamily: 'Roboto-Regular',
                        color: 'red',
                        padding: 5,
                      }}>
                      {avisomsg}
                    </Text>
                  </View>
                ) : (
                  <View style={{height: 30}}></View>
                )}
                <View
                  style={{
                    flex: 1,
                    width: 225,
                    alignItems: 'center',
                    justifyContent: 'center',
                  }}>
                  <TouchableOpacity
                    style={[estilos.btn, {}]}
                    onPress={() => {
                      verificarToken();
                    }}>
                    <Text
                      style={{
                        fontSize: 24,
                        fontFamily: 'Poppins-Regular',
                        color: '#fff',
                        paddingTop: 5,
                      }}>
                      Confirmar
                    </Text>
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
                  Realizando o cadastro...
                </Text>
                <ActivityIndicator size="large" color="#910046" />
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
  conteudo2: {
    marginTop: 30,
    paddingHorizontal: 30,
    flexDirection: 'row',
    alignItems: 'flex-start',
    paddingBottom: 50,
  },
  input: {
    padding: 2,
    fontSize: 17,
    borderBottomWidth: 1,
    borderColor: '#D8d8d8',
    fontFamily: 'Poppins-Regular',
    color: '#000',
  },
  inputToken: {
    width: 60,
    height: 90,
    marginHorizontal: 10,
    fontSize: 40,
    borderWidth: 1,
    borderRadius: 10,
    borderColor: '#910046',
    fontFamily: 'Poppins-Bold',
    color: '#000',
    textAlign: 'center',
    textAlignVertical: 'center',
  },
  btn: {
    marginTop: 20,
    width: '90%',
    height: 45,
    borderRadius: 33,
    backgroundColor: '#910046',
    alignItems: 'center',
    justifyContent: 'center',
  },
  btn2: {
    marginTop: 20,
    width: '90%',
    height: 45,
    borderRadius: 33,
    backgroundColor: '#CCC',
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
    fontSize: 18,
    fontFamily: 'Poppins-Regular',
    marginTop: 10,
    color: '#000',
  },
});
