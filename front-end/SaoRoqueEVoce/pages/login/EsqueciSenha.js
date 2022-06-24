import React, {useState} from 'react';
import {
  StyleSheet,
  Text,
  View,
  TextInput,
  Image,
  TouchableOpacity,
  Modal,
  ActivityIndicator,
  KeyboardAvoidingView,
} from 'react-native';
import {useNavigation} from '@react-navigation/native';
import Header from '../../componentes/Header';
import Token from '../../componentes/Token';
import BtnCancelar from '../../componentes/BtnCancelar';
import CheckBox from '@react-native-community/checkbox';
import axios from 'axios';
import Globais from '../../componentes/Globais';
import AsyncStorage from '@react-native-async-storage/async-storage';

export default function App() {
  const navigation = useNavigation();
  const baseURL = 'http://www.racsstudios.com/api/v1/setuser';
  const [isSelected, setSelection] = useState(false);
  const [mostrar, setMostrar] = useState(false);
  const [email, setEmail] = useState('');
  const [msgerro, setMsgErro] = useState('');
  const [erroSelect, setErroSelect] = useState(false);
  const [cardToken, setCardToken] = useState(false);
  const [carregando, setCarregando] = useState(false);

  const validar = () => {
    let error = false;

    if (email == '') {
      setMsgErro('Insira seu e-mail');
      error = true;
    }
    if (isSelected == false) {
      setErroSelect('Selecione a verificação!');
      error = true;
    }

    return !error;
  };

  const enviarEmail = () => {
    let verificar = true;
    setMsgErro('');
    if (validar()) {
      setCarregando(true);
      axios
        .post(baseURL, {
          redefinirSenha: email,
        })
        .then(response => {
          verificar = false;
          setTimeout(() => {
            setCarregando(false);
            setCardToken(true);
          }, 1500);
        })
        .catch(error => {
          verificar = false;
          if (error) {
            setTimeout(() => {
              setCarregando(false);
              setMsgErro('E-mail não encontrado.');
            }, 1500);
          }
        });
      setTimeout(() => {
        if (verificar === true) {
          setCarregando(false);
          setMsgErro(
            'Não foi possível realizar sua solicitação.\nVerifique sua conexão com a internet\ne tente novamente.',
          );
        }
      }, 6000);
    }
  };

  return (
    <View style={estilos.container}>
      <Header space={true} />
      <View style={{paddingHorizontal: 30}}>
        <Text style={estilos.h1}>Redefina a sua senha</Text>
        <Text style={estilos.txt}>
          Para redefinir a sua senha, digite o seu e-mail cadastrado.
        </Text>
      </View>
      <KeyboardAvoidingView
        style={{flex: 1}}
        behavior={Platform.OS === 'ios' ? 'padding' : 'height'}>
        <View style={{paddingHorizontal: 30, marginTop: 20}}>
          <TextInput
            value={email}
            onChangeText={setEmail}
            placeholder="E-mail"
            placeholderTextColor={'#910046'}
            style={estilos.input}></TextInput>
          {carregando && (
            <View style={{position: 'absolute', top: 15, right: 30}}>
              <ActivityIndicator size={25} color="#910046" />
            </View>
          )}
          <Text style={{color: 'red', height: 50, marginVertical: -15}}>
            {msgerro}
          </Text>
          <View style={estilos.conteudoCkecbox}>
            <View style={estilos.checkbox}>
              <CheckBox
                value={isSelected}
                onValueChange={() => {
                  setSelection(!isSelected);
                  setErroSelect('');
                }}
                style={{transform: [{scaleX: 1.5}, {scaleY: 1.5}]}}
                tintColors={{true: '#910046', false: '#910046'}}
              />
              <Text style={[estilos.txt, {paddingLeft: 10}]}>
                Não sou um robô
              </Text>
            </View>
            <Image source={require('../../images/captchalogo.png')} />
          </View>
          <Text style={{color: 'red'}}>{erroSelect}</Text>
        </View>
        <View style={{height: '50%', justifyContent: 'flex-end', bottom: '8%'}}>
          <TouchableOpacity
            style={estilos.btn}
            onPress={() => {
              enviarEmail();
            }}>
            <Text
              style={{
                fontSize: 24,
                fontFamily: 'Poppins-Regular',
                color: '#CDCDCD',
                padding: 5,
                letterSpacing: 2,
              }}>
              Enviar
            </Text>
          </TouchableOpacity>
          <BtnCancelar />
        </View>
      </KeyboardAvoidingView>
      {cardToken && <Token email={email} />}

      <View>
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
                  <TouchableOpacity
                    onPress={() => navigation.navigate('Login')}>
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
                  <Image
                    source={require('../../images/configuracao/sucesso.png')}
                  />
                  <Text style={[estilos.txtModal, {paddingVertical: 20}]}>
                    Enviamos para seu e-mail instruções para redefinir a sua
                    senha.
                  </Text>
                </View>
              </View>
            </View>
          </Modal>
        </View>
      </View>

      <View>
        <Modal visible={{}} transparent={true}>
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
  h1: {
    fontSize: 24,
    fontFamily: 'Poppins-Regular',
    color: '#910046',
    paddingBottom: 10,
  },
  txt: {
    fontSize: 17,
    fontFamily: 'Poppins-Regular',
    color: '#414141',
  },
  input: {
    width: '100%',
    marginTop: 15,
    marginBottom: 20,
    padding: 2,
    fontSize: 17,
    borderBottomWidth: 1,
    borderColor: '#D8d8d8',
    fontFamily: 'Poppins-Regular',
    color: '#000',
  },
  conteudoCkecbox: {
    marginTop: 30,
    flexDirection: 'row',
    alignItems: 'center',
    borderWidth: 1,
    padding: 20,
    borderRadius: 10,
    borderColor: '#C4CDCD',
    justifyContent: 'space-around',
    backgroundColor: '#EEE',
  },
  checkbox: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
  },
  btn: {
    alignSelf: 'center',
    marginTop: 20,
    width: '75%',
    height: 45,
    borderRadius: 33,
    backgroundColor: '#910046',
    alignItems: 'center',
    justifyContent: 'flex-end',
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
    textAlign: 'center',
  },
});
