import React, {useState, useRef,useEffect} from 'react';
import {
  StyleSheet,
  Text,
  View,
  TextInput,
  Image,
  Modal,
  TouchableOpacity,
  ActivityIndicator,
  Dimensions
} from 'react-native';
import CountDown from 'react-native-countdown-component';
import {useNavigation} from '@react-navigation/native';
import axios from 'axios';
import {Buffer} from 'buffer';

export default function App(props) {
  const navigation = useNavigation();
 const baseURL = 'http://www.racsstudios.com/api/v1/user';
  const [mostrar, setMostrar] = useState(false);
  const [loadingResponse, setLoadingResponse] = useState(false);
  const [versenha, setVersenha] = useState(true);
  const [senha, setSenha] = useState('');
  const [confirmaSenha, setConfirmaSenha] = useState('');
  const [iconsenha, setIconsenha] = useState(require('../images/eye1.png'));
  const [alertasenha, setAlertasenha] = useState('');
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
  const [erroSenha, setErroSenha] = useState('');
  const [usertoken, setUsertoken] = useState('');
  const [erroToken, setErroToken] = useState('');
  const [usernome, setUsernome] = useState(null);
  const [usersobrenome, setUsersobrenome] = useState(null);
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
  const [msg, setMsg] = useState('')
  const [img, setImg] = useState(require('../images/configuracao/sucesso.png'))
  const email = props?.email
  const senhalogin = props?.senha



  const rota = () => {
    if (confirmacao?.email == email) {
      navigation.navigate('Login', {
        hookReload: 'hook' + new Date(),
        email:email, senha:senhalogin
      });
    } else {
      setMostrar(false);
    }
  };
console.log(confirmacao?.email)
  const mostrarsenha = () => {
    setVersenha(!versenha);
    if (versenha == true) {
      setIconsenha(require('../images/eye0.png'));
    } else {
      setIconsenha(require('../images/eye1.png'));
    }
  };

  const validar = () => {
    let error = false;  
    if (pin1 == '' || pin2 == '' || pin3 == '' || pin4 == '') {
      setErroToken('Insira o token!')
      error = true;
    }

    return !error;
  };

  function enviarEmail() {
    setEnviado(true);
    setTempo(150);
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

const validarToken = () => {
  setMsg('')
  if(validar()){
    let validarConexao = true;
      setMostrar(true);
      setLoadingResponse(true);
      let username = email
      let password = usertoken
      const auth = Buffer.from(`${username}:${password}`, 'utf8').toString(
        'base64',
      );
      let body = {       
        token: usertoken,    
      };
      axios
        .put(baseURL, body, {headers: {Authorization: `Basic ${auth}`}})
        .then(response => {
          validarConexao = false;
          console.log(validarConexao);
          setMsg('Sua conta foi ativada com sucesso!');
          setImg(require('../images/configuracao/sucesso.png'));
          setConfirmacao(response.data);     
          setTimeout(() => {
            setLoadingResponse(false);
          }, 2000);
        })
        .catch(error => {
          validarConexao = false;
          console.log(validarConexao);
          if(msg == '' ){
          setImg(require('../images/configuracao/dangericon.png'));
          setMsg('Token inválido, tente novamente.');}
          setTimeout(() => {
            setLoadingResponse(false);
          }, 2000);
        });
        setTimeout(()=> {if (validarConexao == true) {
          console.log(validarConexao);
          setLoadingResponse(false);
          setImg(require('../images/configuracao/dangericon.png'));        
          setMsg('Houve um erro.\nVerifique sua internet\ne tente novamente.');
      }},6000)
      }
}

  return (
    <View>
      <View>
        <Modal visible={true} transparent={true}>
          <View
            style={{
              flex: 1,
              alignItems: 'center',
              backgroundColor: 'rgba(0, 0 , 0, 0.8)',
            }}>
            <View style={[estilos.containerModal, {height: 380, marginTop:'-10%'}]}>
              <View style={{flex: 1, alignItems: 'center'}}>
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
                      marginBottom: -5,
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
                      marginBottom: 0,
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
                      setErroToken('')
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
                      setErroToken('')
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
                      setErroToken('')
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
                      setErroToken('')
                      setUsertoken(
                        String(pin1) +
                          String(pin2) +
                          String(pin3) +
                          String(pin4)
                      );
                    }}
                  />
                </View>
                <Text style={{marginBottom:-15, color:'red'}}>{erroToken}</Text>
                <View style={{flexDirection: 'row', alignItems: 'center'}}>
                  <Text
                    style={[
                      estilos.txtModal,
                      {
                        fontSize: 13,
                        textAlign: 'center',                       
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
                        setAvisomsg('Aguarde para enviar novamente!');
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
                  <View style={{height: 30, marginBottom:10,}}>
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
                        setAvisomsg('Aguarde para solicitar novo código');
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
                  <View style={{height: 40}}></View>
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
                      validarToken();
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
                  <Image source={require('../images/configuracao/close.png')} />
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
                      source={img}
                    />
                    <Text
                      style={[
                        estilos.txtModal,
                        {textAlign: 'center', paddingVertical: 10},
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
  containerModal: {
    alignSelf: 'center',
    width: Dimensions.get('window').width - Dimensions.get('window').width * 0.1,
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
  inputToken: {
    width: 40,
    height: 50,
    marginHorizontal: 5,
    fontSize: 25,
    borderWidth: 1,
    borderRadius: 10,
    borderColor: '#910046',
    fontFamily: 'Poppins-Bold',
    color: '#000',
    textAlign: 'center',
    paddingBottom: 0,
  },
  btn: {
    marginTop: 0,
    width: '90%',
    height: 45,
    borderRadius: 33,
    backgroundColor: '#910046',
    alignItems: 'center',
    justifyContent: 'center',
  },
  containerInput: {
    width: '100%',
    height: 50,
    borderColor: '#E7E7E7',
    backgroundColor: '#E7E7E7',
    fontFamily: 'Poppins-Regular',
    borderRadius: 8,
    paddingLeft:10,
  },
  img: {
    height: 25,
    width: 25,
    resizeMode: 'contain',
  },
  input: {
      fontSize:16,
      color:'#910046',
  }
});
