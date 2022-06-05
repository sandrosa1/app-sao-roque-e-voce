import React, {useState, useEffect} from 'react';
import {
  StyleSheet,
  SafeAreaView,
  Text,
  View,
  ImageBackground,
  Image,
  TextInput,
  TouchableOpacity,
  Dimensions,
  KeyboardAvoidingView,
  Modal,
  ActivityIndicator,
} from 'react-native';
import axios from 'axios';
import Globais from '../../componentes/Globais';
import TokenLogin from '../../componentes/TokenLogin';
import AsyncStorage from '@react-native-async-storage/async-storage';

export default function App({navigation, route}) {
  const baseURL = 'http://www.racsstudios.com/api/v1/login';
  const [email, setEmail] = useState('');
  const [senha, setSenha] = useState('');
  const [versenha, setVersenha] = useState(true);
  const [iconsenha, setIconsenha] = useState(require('../../images/eye1.png'));
  const [confirmacao, setConfirmacao] = useState(null);
  const [mostrar, setMostrar] = useState(false);
  const [cardToken, setCardToken] = useState(false);
  const [mostrarindicator, setMostrarindicator] = useState(false);
  const [mostrarerro, setMostrarerro] = useState(false);
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
  const [msg, setMsg] = useState('');
  const reload = route.params?.hookReload;

  useEffect(() => {
   if(reload) {
    setCardToken(false)
    setEmail(route.params.email); 
    setSenha(route.params.senha); 
    login()
   }
  }, [reload]);

  const salvar = async () => {
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
      await AsyncStorage.setItem('usuario', jsonValue);
      console.log(jsonValue);
    } catch (e) {
      console.log(e);
    }
  };

  const dadosdousuario = async () => {
    const json = await AsyncStorage.getItem('usuario');
    if (json) {
      Globais.dados = JSON.parse(json);
    }
  };

  function login() {
    if (email == '' || senha == '') {
      setMsg('Insira seu email e senha!\nou crie uma nova conta!');
      setMostrarerro(true);
    } else {
      axios
        .post(baseURL, {
          email: email,
          senha: senha,
        })
        .then(response => {
          setConfirmacao(response.data);
          if(response.data.error == 'Precizar confirmar token'){
            setCardToken(true)
            enviarEmail()
          }
          console.log(response.data);
        })
        .catch(error => {
          setError(error.response.data);
        });
    }
  }

  function enviarEmail() {
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

  if (confirmacao) {
    if (
      confirmacao.error == 'Email ou senha inválido!' ||
      confirmacao.error == 'Senha ou Email inválido!'
    ) {
      setMsg('E-mail ou Senha inválido!');
      setMostrarerro(true);
      setConfirmacao();
    } else if (confirmacao.retorne == true) {
      setUsernome(
        confirmacao.nomeUsuario[0]?.toUpperCase() +
          confirmacao.nomeUsuario?.substr(1),
      );
      setUsersobrenome(
        confirmacao.sobreNome[0]?.toUpperCase() +
          confirmacao.sobreNome?.substr(1),
      );
      setUsertoken(confirmacao.token);
      setUseremail(confirmacao.email);
      setUseridusuario(confirmacao.idUsuario);
      setUsernascimento(confirmacao.dataNascimento);
      setUserdicasrestaurante(confirmacao.dicasRestaurantes);
      setUserdicasturismo(confirmacao.dicasPontosTuristicos);
      setUserdicashospedagem(confirmacao.dicasHospedagens);
      setUserativalocalizacao(confirmacao.ativaLocalizacao);
      setUseralertanovidade(confirmacao.alertaNovidade);
      setUseralertaevento(confirmacao.alertaEventos);
      load();
      setConfirmacao();
    }
  }

  function load() {
    setMostrarindicator(true);
    salvar();
    dadosdousuario();
    setTimeout(() => {
      setMostrarindicator(false);
      setMostrar(true);
    }, 3000);
  }

  const mostrarsenha = () => {
    setVersenha(!versenha);
    if (versenha == true) {
      setIconsenha(require('../../images/eye0.png'));
    } else {
      setIconsenha(require('../../images/eye1.png'));
    }
  };

  useEffect(() => {
    if (usernome != null) {
      load();
    }
  }, [useremail]);

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

  return (
    <SafeAreaView style={estilos.conteiner}>
      <ImageBackground
        source={require('../../images/backgroundlogin.png')}
        style={estilos.imagemfundo}
        resizeMode="cover">
        <View style={estilos.conteudo}>
          <TouchableOpacity onPress={() => navigation.navigate('Home')}>
            <Image
              source={require('../../images/logo.png')}
              style={{width: '100%', resizeMode: 'contain'}}
            />
          </TouchableOpacity>
        </View>
        <KeyboardAvoidingView
          style={{flex: 1}}
          behavior={Platform.OS === 'ios' ? 'padding' : 'height'}>
          <View style={estilos.conteudo2}>
            <Text
              style={{
                fontSize: 24,
                marginTop: 50,
                fontFamily: 'Poppins-SemiBold',
                color: '#910046',
              }}>
              Login
            </Text>
            <TextInput
              onChangeText={setEmail}
              value={email}
              placeholder="E-mail"
              placeholderTextColor={'#910046'}
              style={estilos.input}></TextInput>

            <View
              style={{
                width: '100%',
                marginTop: 15,
                marginBottom: 25,
                flexDirection: 'row',
                alignItems: 'center',
                justifyContent: 'center',
              }}>
              <TextInput
                value={senha}
                onChangeText={value => {
                  setSenha(value);
                }}
                placeholder="Senha"
                secureTextEntry={versenha}
                placeholderTextColor={'#910046'}
                style={estilos.input}></TextInput>

              <TouchableOpacity
                style={{position: 'absolute', right: 10}}
                onPress={mostrarsenha}>
                <View style={{padding: 7}}>
                  <Image style={{width: 25, height: 25}} source={iconsenha} />
                </View>
              </TouchableOpacity>
            </View>

            <TouchableOpacity style={estilos.btn} onPress={login}>
              <Text
                style={{
                  fontSize: 24,
                  fontFamily: 'Poppins-Regular',
                  color: '#910046',
                  letterSpacing: 2,
                  paddingTop: 5,
                }}>
                ENTRAR
              </Text>
            </TouchableOpacity>
          </View>
        </KeyboardAvoidingView>
        <View style={estilos.conteudo3}>
          <TouchableOpacity onPress={() => navigation.navigate('EsqueciSenha')}>
            <Text
              style={{
                fontSize: 14,
                color: '#DCDCDC',
                textAlign: 'center',
                fontFamily: 'Poppins-Regular',
              }}>
              Esqueceu sua senha?
            </Text>
          </TouchableOpacity>
          <TouchableOpacity onPress={() => navigation.navigate('Cadastro')}>
            <Text
              style={{
                fontSize: 14,
                fontFamily: 'Poppins-Regular',
                color: '#DCDCDC',
                textAlign: 'center',
              }}>
              Ainda não é usuário?{' '}
              <Text style={{fontSize: 14, fontFamily: 'Poppins-Bold'}}>
                Crie sua conta aqui!
              </Text>
            </Text>
          </TouchableOpacity>
        </View>

        {cardToken &&
      <TokenLogin email={email} senha={senha}/>}

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
                  <Image
                    style={{width: 50, height: 50}}
                    source={require('../../images/configuracao/dangericon.png')}
                  />
                  <Text style={[estilos.txtModal, {paddingVertical: 5}]}>
                    {msg}
                  </Text>
                  <Text style={[estilos.txtModal, {marginTop: 0}]}>
                    Tente novamente.
                  </Text>
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
              <View style={[estilos.containerModal,{height:260}]}>
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
                  <Image
                    style={{width: 50, height: 50, marginBottom: 10}}
                    source={require('../../images/configuracao/sucesso.png')}
                  />
                  <Text style={[estilos.txtModal, {paddingVertical: 10,textAlign: 'center'}]}>
                    Bem vindo!{'\n'}{Globais.dados?.usernome}{' '}
                    {Globais.dados?.usersobrenome}
                  </Text>
                  <TouchableOpacity style={estilos.btn2} onPress={rota}>
                    <Text
                      style={{
                        fontSize: 24,
                        fontFamily: 'Poppins-Regular',
                        color: '#fff',
                        letterSpacing: 2,
                        paddingTop: 5,
                      }}>
                      ok
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
                    Conectando...
                  </Text>
                  <ActivityIndicator size="large" color="#910046" />
                </View>
              </View>
            </View>
          </Modal>
        </View>
      </ImageBackground>
    </SafeAreaView>
  );
}

const estilos = StyleSheet.create({
  conteiner: {
    flex: 1,
  },
  imagemfundo: {
    width: Dimensions.get('window').width,
    height: Dimensions.get('window').height,
  },
  conteudo: {
    justifyContent: 'flex-end',
    paddingHorizontal: 40,
  },
  conteudo2: {
    flex: 2,
    padding: 40,
    alignItems: 'center',
    justifyContent: 'center',
  },
  conteudo3: {
    flex: 1,
    padding: 40,
    alignItems: 'center',
    justifyContent: 'space-around',
  },
  input: {
    width: '90%',
    marginTop: 15,
    padding: 2,
    fontSize: 17,
    borderBottomWidth: 1,
    borderColor: '#D8d8d8',
    fontFamily: 'Poppins-Regular',
    color: '#000',
  },
  btn: {
    marginTop: 45,
    width: '90%',
    height: 45,
    backgroundColor: 'lightgray',
    borderRadius: 33,
    alignItems: 'center',
    justifyContent: 'center',
  },
  btn2: {
    marginTop: 5,
    width: '50%',
    height: 45,
    backgroundColor: '#910046',
    borderRadius: 33,
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
    fontSize: 15,
    fontFamily: 'Poppins-Regular',
    margin: 0,
    color: '#000',
  },
});
