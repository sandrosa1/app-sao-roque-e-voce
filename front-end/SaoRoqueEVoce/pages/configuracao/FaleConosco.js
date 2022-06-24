import React, {useState, useEffect} from 'react';
import {
  StyleSheet,
  Text,
  View,
  TouchableOpacity,
  Image,
  Modal,
  ActivityIndicator,
  TextInput,
  ScrollView,
} from 'react-native';
import Header from '../../componentes/Header';
import {useNavigation} from '@react-navigation/native';
import Globais from '../../componentes/Globais';
import axios from 'axios';

export default function App({navigate}) {
  const navigation = useNavigation();
  const baseURL = 'http://www.racsstudios.com/api/v1/report';
  const [loadingResponse, setLoadingResponse] = useState(false);
  const [msg, setMsg] = useState(false);
  const [img, setImg] = useState(
    require('../../images/configuracao/dangericon.png'),
  );
  const [mostrarOpcoes, setMostrarOpcoes] = useState(false);

  const [selecione, setSelecione] = useState('Selecione');
  const [nome, setNome] = useState('');
  const [email, setEmail] = useState('');
  const [mensagem, setMensagem] = useState('');
  const [erronome, setErronome] = useState('');
  const [erroemail, setErroemail] = useState('');
  const [erroMsg, setErroMsg] = useState('');
  const [erroSelecione, setErroSelecione] = useState('');
  const [mostrar, setMostrar] = useState('');

  useEffect(() => {
    if (Globais.dados?.usernome) {
      setNome(Globais.dados?.usernome);
      setEmail(Globais.dados?.useremail);
    }
  }, []);

  const validar = () => {
    let error = false;
    setErronome('');
    setErroemail('');
    setErroMsg('');
    setErroSelecione('');
    const re =
      /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

    if (nome == '') {
      setErronome('Preencha o seu nome!');
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

    if (selecione == 'Selecione') {
      setErroSelecione('Selecione o tipo da mensagem!');
      error = true;
    }
    if (mensagem == '') {
      setErroMsg('Insira a sua mensagem!');
      error = true;
    }
    return !error;
  };

  const enviarMensagem = () => {
    setMsg('');
    setImg();
    if (validar()) {
      setMostrar(true);
      setLoadingResponse(true);
      axios
        .post(baseURL, {
          nome: nome,
          email: email,
          typeReport: selecione,
          message: mensagem,
        })
        .then(response => {
          console.log(response.data);
          if (response.data.retorno == 'success') {
            setImg(require('../../images/configuracao/sucesso.png'));
            setMsg(
              'Sua mensagem foi enviada com sucesso!\nAgradecemos seu contato',
            );
            setTimeout(() => {
              setLoadingResponse(false);
            }, 1500);
          } else {
            setImg(require('../../images/configuracao/dangericon.png'));
            setMsg(
              'Houve um problema ao enviar sua mensagem.\nTente novamente.',
            );
            setTimeout(() => {
              setLoadingResponse(false);
            }, 1500);
          }
        })
        .catch(error => {
          console.log(error.message);
        });
    }
  };

  return (
    <View style={estilos.container}>
      <ScrollView>
        <View style={{flex: 1, paddingHorizontal: 30}}>
          <Header goingback={true} space={true} />
          <Text style={estilos.h1}>Fale Conosco</Text>
          <Text style={estilos.txt}>
            Econtrou algum problema ou dificuldade?
          </Text>
          <Text style={estilos.txt}>Envie-nos uma mensagem.</Text>
        </View>

        <View style={{flex: 1, paddingHorizontal: 30}}>
          <View>
            <View style={{marginTop: 15}}>
              <TextInput
                value={nome}
                onChangeText={setNome}
                placeholder={'Insira o seu nome'}
                placeholderTextColor={'#414141'}
                style={estilos.input}></TextInput>
              <Text style={{position: 'absolute', top: 50, color: '#910046'}}>
                {erronome}
              </Text>
            </View>
            <View style={{marginTop: 20}}>
              <TextInput
                value={email}
                onChangeText={setEmail}
                keyboardType="email-address"
                placeholder={'Insira o seu e-mail'}
                placeholderTextColor={'#414141'}
                style={estilos.input}></TextInput>
              <Text style={{position: 'absolute', top: 50, color: '#910046'}}>
                {erroemail}
              </Text>
            </View>
          </View>
          <View style={{marginTop: 15}}>
            <View style={{flexDirection: 'row', justifyContent: 'center'}}>
              <View style={{flex: 3, justifyContent: 'center'}}>
                <Text style={estilos.txtOption}>Tipo da mensagem:</Text>
              </View>
              <TouchableOpacity
                style={{flex: 1, padding: 10}}
                onPress={() => {
                  setMostrarOpcoes(true);
                }}>
                <Text style={estilos.txtOption}>{selecione}</Text>
              </TouchableOpacity>
            </View>
            <Text style={{position: 'absolute', top: 30, color: '#910046'}}>
              {erroSelecione}
            </Text>
          </View>
          <View style={{marginTop: 15, marginBottom: 30}}>
            <TextInput
              onSubmitEditing={() => {
                enviarMensagem();
              }}
              value={mensagem}
              onChangeText={setMensagem}
              placeholder={'Insira a sua mensagem...'}
              placeholderTextColor={'#414141'}
              style={estilos.inputMsg}></TextInput>
            <Text style={{position: 'absolute', top: 200, color: '#910046'}}>
              {erroMsg}
            </Text>
          </View>
        </View>

        <View style={estilos.containerBtn}>
          <TouchableOpacity
            style={[estilos.btn, {backgroundColor: '#920049'}]}
            onPress={() => {
              enviarMensagem();
            }}>
            <Text
              style={{
                fontSize: 24,
                fontFamily: 'Poppins-Regular',
                color: '#D8D8D8',
                padding: 5,
              }}>
              Enviar mensagem
            </Text>
          </TouchableOpacity>
        </View>

        <View>
          <Modal visible={mostrarOpcoes} transparent={true}>
            <View
              style={{
                flex: 1,
                alignItems: 'center',
                backgroundColor: 'rgba(0, 0 , 0, 0.8)',
              }}>
              <View style={estilos.containerModal}>
                <Text style={estilos.txtOption2}>
                  Selecione o tipo da mensagem:
                </Text>
                <View style={{paddingHorizontal: 20, paddingVertical: 10}}>
                  <TouchableOpacity
                    style={estilos.option}
                    onPress={() => {
                      setMostrarOpcoes(false);
                      setSelecione('Erro');
                    }}>
                    <Text style={estilos.txtOption}>Erro</Text>
                  </TouchableOpacity>
                  <TouchableOpacity
                    style={estilos.option}
                    onPress={() => {
                      setMostrarOpcoes(false);
                      setSelecione('elogio');
                    }}>
                    <Text style={estilos.txtOption}>Elogio</Text>
                  </TouchableOpacity>
                  <TouchableOpacity
                    style={estilos.option}
                    onPress={() => {
                      setMostrarOpcoes(false);
                      setSelecione('denuncia');
                    }}>
                    <Text style={estilos.txtOption}>Denúncia</Text>
                  </TouchableOpacity>
                  <TouchableOpacity
                    style={estilos.option}
                    onPress={() => {
                      setMostrarOpcoes(false);
                      setSelecione('outros');
                    }}>
                    <Text style={estilos.txtOption}>Outros</Text>
                  </TouchableOpacity>
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
              <View style={[estilos.containerModal, {height: 230}]}>
                <View style={{alignItems: 'flex-end'}}>
                  <TouchableOpacity
                    onPress={() => {
                      setMostrar(false);
                      setNome('');
                      setEmail('');
                      setMensagem('');
                      setSelecione('Selecione');
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
                        marginBottom: 75,
                        alignItems: 'center',
                        justifyContent: 'center',
                      }}>
                      <ActivityIndicator size={75} color="#910046" />
                    </View>
                  ) : (
                    <View
                      style={{
                        alignItems: 'center',
                        justifyContent: 'center',
                      }}>
                      <Image source={img} />
                      <Text style={[estilos.txtModal, {paddingVertical: 15}]}>
                        {msg}
                      </Text>
                    </View>
                  )}
                </View>
              </View>
            </View>
          </Modal>
        </View>
      </ScrollView>
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
  txtOption2: {
    fontSize: 16,
    fontFamily: 'Poppins-Bold',
    color: '#414141',
  },
  option: {
    fontSize: 16,
    fontFamily: 'Poppins-Bold',
    color: '#414141',
    padding: 5,
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
    bottom: '3%',
  },
  containerModal: {
    alignSelf: 'center',
    width: 350,
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
    color: '#000',
  },
  input: {
    width: '100%',
    height: 50,
    fontSize: 14,
    padding: 13,
    borderColor: '#E7E7E7',
    backgroundColor: '#E7E7E7',
    fontFamily: 'Poppins-Regular',
    borderRadius: 8,
    color: '#333',
  },
  inputMsg: {
    width: '100%',
    height: 200,
    fontSize: 14,
    padding: 13,
    borderColor: '#E7E7E7',
    backgroundColor: '#E7E7E7',
    fontFamily: 'Poppins-Regular',
    borderRadius: 8,
    color: '#333',
    textAlignVertical: 'top',
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
