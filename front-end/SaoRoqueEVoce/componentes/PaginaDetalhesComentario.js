import React, {useState, useRef, useEffect} from 'react';
import {
  StyleSheet,
  Text,
  View,
  Image,
  Dimensions,
  TouchableOpacity,
  FlatList,
  TextInput,
  ActivityIndicator,
  Modal,
} from 'react-native';
import {useNavigation} from '@react-navigation/native';
import NavPages from './NavPages';
import SeparadorComentario from './SeparadorComentario';
import CardMeusComentarios from './CardMeusComentarios';
import axios from 'axios';
import AsyncStorage from '@react-native-async-storage/async-storage';
import CardComentarios from './CardComentarios';
import Carousel from 'react-native-snap-carousel';
import Globais from './Globais';
import {useIsFocused} from '@react-navigation/native';
import {Buffer} from 'buffer';

export default function App({route}) {
  const navigation = useNavigation();
  const [rank, setRank] = useState(0);
  const [custo, setCusto] = useState(0);
  const url = `http://www.racsstudios.com/api/v1/apps/${route.params.id}`;
  const [dados, setDados] = useState([]);
  const [listacomentarios, setlistaComentarios] = useState();
  const [filtro, setFiltro] = useState(listacomentarios);
  const [comentarioUsuario, setComentarioUsuario] = useState([]);
  const [mostrarComentarioUsuario, setMostrarComentarioUsuario] =
    useState(false);
  const [additem, setAdditem] = useState(5);
  const [comentario, setComentario] = useState();
  const [loading, setLoading] = useState(false);
  const [loading2, setLoading2] = useState(false);
  const [loadingResponse, setLoadingResponse] = useState(false);
  const [mostrar, setMostrar] = useState(false);
  const [mostrarinput, setMostrarinput] = useState(false);
  const [mostrarcadastro, setMostrarCadastro] = useState(false);
  const [confirmacao, setConfirmacao] = useState();
  const [mostrarcomentarios, setMostrarcomentarios] = useState(false);
  const [verificar, setVerificar] = useState(0);
  const [error, setError] = useState();
  const [show, setShow] = useState();
  const [img, setImg] = useState();
  const [msg, setMsg] = useState('');
  const reload = route.params?.hookReload;
  const reload2 = route.params?.hookReload2;
  const {width, height} = Dimensions.get('window');
  const isFocused = useIsFocused();
  const scrollRef = useRef();

  useEffect(() => {
    loadApi();
    setComentario('');
    setRank(0);
    setCusto(0);
  }, [additem, isFocused, reload]);

  useEffect(() => {
    if (isFocused) {
      setShow(false);
      setTimeout(() => {
        setShow(true);
      }, 1);
    }
  }, [reload2, isFocused]);

  async function loadApi() {
    if (loading) return;
    setLoading(true);
    const response = await axios.get(`${url}`);
    setDados(response.data);
    try {
      const responseComentario = await axios.get(
        `http://www.racsstudios.com/api/v1/commentall/${route.params.id}/`,
      );
      setlistaComentarios(responseComentario.data.comments);
      setMostrarcomentarios(true);
      setLoading2(false);

      setTimeout(() => {
        setLoading(false);
      }, 500);
    } catch (e) {
      if (e) {
        setTimeout(() => {
          setLoading(false);
        }, 200);
      }
    }
  }

  useEffect(() => {
    setComentarioUsuario(
      listacomentarios?.filter((item, indice) => {
        if (item.idUsuario == Globais.dados?.useridusuario) {
          setMostrarComentarioUsuario(true);
          setRank(item.avaliacao);
          return true;
        }
      }),
    );
  }, [listacomentarios]);

  useEffect(() => {
    setFiltro(
      listacomentarios?.filter((item, indice) => {
        if (indice < additem) {
          return true;
        }
      }),
    );
  }, [listacomentarios]);

  if (
    JSON.stringify(comentarioUsuario) == '[]' &&
    mostrarComentarioUsuario == true
  ) {
    setMostrarComentarioUsuario(false);
    setRank(0);
    setMostrarinput(false);
  }

  let ranks = rank;
  let custos = custo;
  let estrelas = dados.estrelas;
  let arrayrank = [];
  let arraycusto = [];
  let arrayestrela = [];
  let id = route.params.id;

  let i = 0;
  for (i = 0; i < 5; i++) {
    if (ranks > 0.5) {
      arrayrank[i] = require('../images/paginadetalhes/star1.png');
      ranks = ranks - 1;
    } else {
      arrayrank[i] = require('../images/paginadetalhes/star0.png');
    }
  }

  for (i = 0; i < 5; i++) {
    if (custos > 0.5) {
      arraycusto[i] = require('../images/paginadetalhes/custo1.png');
      custos = custos - 1;
    } else {
      arraycusto[i] = require('../images/paginadetalhes/custo0.png');
    }
  }

  for (i = 0; i < 5; i++) {
    if (estrelas > 0.5) {
      arrayestrela[i] = require('../images/paginadetalhes/star1.png');
      estrelas = estrelas - 1;
    } else {
      if (estrelas <= 0.5 && estrelas > 0) {
        arrayestrela[i] = require('../images/paginadetalhes/star2.png');
        estrelas = 0;
      } else {
        arrayestrela[i] = require('../images/paginadetalhes/star0.png');
      }
    }
  }

  useEffect(() => {
    if (rank > 0 && Globais.dados?.usernome != null) {
      setMostrarinput(true);
    } else if (rank > 0) {
      setMostrarCadastro(true);
    }
  }, [rank, isFocused]);

  let tipo = '';
  let icon = '';

  if (dados.segmento == 'turismo') {
    tipo = 'Turismo';
    icon = require('../images/menubar/pontos.png');
  }
  if (dados.segmento == 'hospedagem') {
    tipo = 'Hospedagem';
    icon = require('../images/menubar/hotel.png');
  }
  if (dados.segmento == 'gastronomia') {
    tipo = 'Gastronomia';
    icon = require('../images/menubar/gastronomia.png');
  }
  if (dados.segmento == 'evento') {
    tipo = 'Eventos';
    icon = require('../images/menubar/evento.png');
  }
  if (dados.segmento == 'comercio') {
    tipo = 'Com??rcio';
    icon = require('../images/menubar/comercio.png');
  }
  if (dados.segmento == 'servicos') {
    tipo = 'Servi??os';
    icon = require('../images/menubar/pontos.png');
  }

  function inserircomentario() {
    setMostrar(true);
    setLoadingResponse(true);
    let username = Globais.dados.useremail;
    let password = Globais.dados.usertoken;
    const token = Buffer.from(`${username}:${password}`, 'utf8').toString(
      'base64',
    );
    let baseURL = 'http://www.racsstudios.com/api/v1/comment/';
    let body = {
      idApp: id,
      comentario: comentario,
      avaliacao: rank,
      custo: custo,
    };
    axios
      .post(baseURL, body, {headers: {Authorization: `Basic ${token}`}})
      .then(response => {
        setConfirmacao(response.data);
        setImg(require('../images/configuracao/sucesso.png'));
        setMsg('Coment??rio inserido com sucesso!');
        setTimeout(() => {
          setLoadingResponse(false);
          setMostrarinput(false);
        }, 1000);
      })
      .catch(error => {
        setError(error.response.data);
        setImg(require('../images/configuracao/error.png'));
        if (
          error.response.error == 'Existe palavras impr??prias no com??ntario'
        ) {
          setMsg('N??o use vocabul??rio impr??prio!');
          setTimeout(() => {
            setLoadingResponse(false);
            setMostrarinput(false);
          }, 1000);
        }
      });
  }

  useEffect(() => {
    const dadosdousuario = async () => {
      const json = await AsyncStorage.getItem('usuario');
      if (json) {
        Globais.dados = JSON.parse(json);
      }
    };
    dadosdousuario();
    setRank(0);
    setCusto(0);
    setMostrarCadastro(false);
  }, [isFocused]);

  let meuscomentarios = route.params?.meuscomentarios;
  const rota = () => {
    if (meuscomentarios == 'meuscomentarios') {
      navigation.navigate('Comentarios');
    } else {
      navigation.navigate('PaginaDetalhes', {
        id: id,
      });
    }
  };

  return (
    <View style={estilos.container}>
      <NavPages icon={icon} title={tipo} />
      <View>
        <Text
          style={{
            fontSize: 24,
            fontFamily: 'Roboto-Bold',
            textAlign: 'center',
            color: '#000',
            marginTop: -10,
          }}>
          {dados.nomeFantasia}
        </Text>
      </View>
      <Modal visible={show} animationType="slide" transparent={true}>
        <View
          style={{
            flex: 1,
            alignItems: 'center',
            backgroundColor: 'rgba(0, 0 , 0, 0.8)',
          }}>
          <View style={estilos.containerModal2}>
            <View
              style={{
                position: 'absolute',
                alignSelf: 'flex-end',
                padding: 20,
                zIndex: 99,
              }}>
              <TouchableOpacity
                onPress={() => {
                  navigation.navigate('PaginaDetalhes', {
                    id: id,
                  });
                }}>
                <Image
                  style={{height: 25, width: 25}}
                  source={require('../images/configuracao/close.png')}
                />
              </TouchableOpacity>
            </View>
            <FlatList
              onLayout={event => console.log(event.nativeEvent.layout)}
              ref={scrollRef}
              style={{width: width, height: height}}
              showsVerticalScrollIndicator={false}
              data={filtro}
              keyExtractor={item => String(item.idComment)}
              renderItem={({item}) => <CardComentarios dados={item} />}
              ItemSeparatorComponent={SeparadorComentario}
              ListHeaderComponent={
                <>
                  <View style={{flex: 1}}>
                    <View style={{marginHorizontal: 30}}>
                      <Text style={estilos.h1}>
                        O que voc?? achou desse local?
                      </Text>
                      {!mostrarComentarioUsuario && (
                        <Text style={estilos.txt}>
                          Escolha de 1 a 5 estrelas para classificar.
                        </Text>
                      )}
                    </View>
                    <View
                      style={{
                        marginHorizontal: 30,
                        flexDirection: 'row',
                        justifyContent: 'space-between',
                        alignItems: 'center',
                      }}>
                      <View style={{flex: 1, flexDirection: 'row'}}>
                        <TouchableOpacity
                          onPress={() => setRank(1)}
                          disabled={mostrarComentarioUsuario}>
                          <Image style={estilos.star} source={arrayrank[0]} />
                        </TouchableOpacity>
                        <TouchableOpacity
                          onPress={() => setRank(2)}
                          disabled={mostrarComentarioUsuario}>
                          <Image style={estilos.star} source={arrayrank[1]} />
                        </TouchableOpacity>
                        <TouchableOpacity
                          onPress={() => setRank(3)}
                          disabled={mostrarComentarioUsuario}>
                          <Image style={estilos.star} source={arrayrank[2]} />
                        </TouchableOpacity>
                        <TouchableOpacity
                          onPress={() => setRank(4)}
                          disabled={mostrarComentarioUsuario}>
                          <Image style={estilos.star} source={arrayrank[3]} />
                        </TouchableOpacity>
                        <TouchableOpacity
                          onPress={() => setRank(5)}
                          disabled={mostrarComentarioUsuario}>
                          <Image style={estilos.star} source={arrayrank[4]} />
                        </TouchableOpacity>
                      </View>
                    </View>
                  </View>
                  {mostrarComentarioUsuario && (
                    <View>
                      <FlatList
                        ListHeaderComponent={
                          <Text
                            style={[
                              estilos.h1,
                              {marginTop: 20, marginHorizontal: 20},
                            ]}>
                            Seu coment??rio:
                          </Text>
                        }
                        showsVerticalScrollIndicator={false}
                        data={comentarioUsuario}
                        keyExtractor={item => String(item.idComment)}
                        renderItem={({item}) => (
                          <CardMeusComentarios
                            data={item}
                            props={item}
                            icon={icon}
                            tipo={tipo}
                          />
                        )}
                      />
                    </View>
                  )}
                  {mostrarcadastro ? (
                    <View style={{marginHorizontal: 30, marginVertical: 20}}>
                      <View
                        style={{flexDirection: 'row', alignItems: 'center'}}>
                        <Image
                          style={estilos.star}
                          source={require('../images/paginadetalhes/warning-purple.png')}
                        />
                        <Text
                          style={{
                            fontFamily: 'Poppins-Regular',
                            fontSize: 16,
                            color: '#000',
                          }}>
                          Entre ou cadastre-se para interagir!
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
                          style={estilos.btn}
                          onPress={() => {
                            navigation.navigate('Login', {
                              id: id,
                              tipo: tipo,
                              icon: icon,
                            });
                          }}>
                          <Text style={estilos.txtBtn}>ENTRAR</Text>
                        </TouchableOpacity>
                        <TouchableOpacity
                          style={[estilos.btn, {backgroundColor: '#920046'}]}
                          onPress={() =>
                            navigation.navigate('Cadastro', {
                              id: id,
                              tipo: tipo,
                              icon: icon,
                            })
                          }>
                          <Text style={[estilos.txtBtn, {color: 'white'}]}>
                            CADASTRAR
                          </Text>
                        </TouchableOpacity>
                      </View>
                    </View>
                  ) : (
                    <View></View>
                  )}

                  {mostrarinput && !mostrarComentarioUsuario ? (
                    <View style={{marginHorizontal: 30, marginVertical: 20}}>
                      <View
                        style={{
                          flexDirection: 'row',
                          alignItems: 'center',
                          justifyContent: 'space-between',
                          marginHorizontal: 5,
                        }}>
                        <View
                          style={{flexDirection: 'row', alignItems: 'center'}}>
                          <Image
                            style={estilos.star}
                            source={require('../images/paginadetalhes/comentario-icon.png')}
                          />
                          <Text
                            style={{
                              fontFamily: 'Poppins-SemiBold',
                              fontSize: 16,
                              color: '#000',
                              marginLeft: 10,
                            }}>
                            Deixe seu coment??rio
                          </Text>
                        </View>
                        <TouchableOpacity
                          onPress={() => {
                            setMostrarinput(false);
                            setRank(0);
                            setCusto(0);
                            setComentario('');
                          }}>
                          <Image
                            style={{height: 25, width: 25}}
                            source={require('../images/configuracao/close.png')}
                          />
                        </TouchableOpacity>
                      </View>
                      <View
                        style={{
                          flexDirection: 'row',
                          alignItems: 'center',
                          justifyContent: 'space-around',
                          marginTop: 20,
                        }}>
                        <TextInput
                          multiline={true}
                          onSubmitEditing={() => {
                            inserircomentario();
                          }}
                          value={comentario}
                          onChangeText={setComentario}
                          style={estilos.input}
                          placeholder={'Conte-nos sua experi??ncia. (opcional)'}
                          placeholderTextColor={'#414141'}></TextInput>
                      </View>
                      <View
                        style={{
                          flexDirection: 'row',
                          alignItems: 'center',
                          justifyContent: 'space-around',
                          marginTop: 10,
                        }}>
                        <View>
                          <Text style={[estilos.txt, {bottom: 1}]}>
                            O que achou dos pre??os?
                          </Text>
                          <View style={{flexDirection: 'row'}}>
                            <TouchableOpacity onPress={() => setCusto(1)}>
                              <Image
                                style={estilos.star}
                                source={arraycusto[0]}
                              />
                            </TouchableOpacity>
                            <TouchableOpacity onPress={() => setCusto(2)}>
                              <Image
                                style={estilos.star}
                                source={arraycusto[1]}
                              />
                            </TouchableOpacity>
                            <TouchableOpacity onPress={() => setCusto(3)}>
                              <Image
                                style={estilos.star}
                                source={arraycusto[2]}
                              />
                            </TouchableOpacity>
                            <TouchableOpacity onPress={() => setCusto(4)}>
                              <Image
                                style={estilos.star}
                                source={arraycusto[3]}
                              />
                            </TouchableOpacity>
                            <TouchableOpacity onPress={() => setCusto(5)}>
                              <Image
                                style={estilos.star}
                                source={arraycusto[4]}
                              />
                            </TouchableOpacity>
                          </View>
                          <View
                            style={{
                              flexDirection: 'row',
                              justifyContent: 'space-between',
                            }}>
                            <Text style={{color: '#910046'}}>Baixo</Text>
                            <Text style={{marginRight: 6, color: '#910046'}}>
                              Alto
                            </Text>
                          </View>
                        </View>
                        <TouchableOpacity
                          style={[estilos.btn, {width: '40%', height: 40}]}
                          onPress={inserircomentario}>
                          <Text style={estilos.txtBtn}>Avaliar</Text>
                        </TouchableOpacity>
                      </View>
                    </View>
                  ) : (
                    <View></View>
                  )}

                  {mostrarcomentarios ? (
                    <View style={{marginTop: 20}}>
                      <View
                        style={{
                          flexDirection: 'row',
                          justifyContent: 'space-between',
                          marginHorizontal: 30,
                        }}>
                        <View style={{flexDirection: 'row'}}>
                          <Text style={estilos.h1}>Avalia????es</Text>
                          <View style={{width: 50}}>
                            <Image
                              style={{marginLeft: 5, width: 21, height: 21}}
                              source={require('../images/paginadetalhes/minichat.png')}
                            />
                            <Text
                              style={{
                                fontSize: 12,
                                fontFamily: 'Roboto-Bold',
                                position: 'absolute',
                                top: 8,
                                left: 18,
                                color: '#000',
                              }}>
                              {dados.avaliacao}
                            </Text>
                          </View>
                        </View>
                        <View
                          style={{flexDirection: 'row', alignItems: 'center'}}>
                          <Text
                            style={[
                              estilos.h1,
                              {fontSize: 15, paddingRight: 10, top: 2},
                            ]}>
                            {dados.estrelas}/5
                          </Text>
                          <View style={{flexDirection: 'row'}}>
                            <Image
                              style={estilos.ministar}
                              source={arrayestrela[0]}
                            />
                            <Image
                              style={estilos.ministar}
                              source={arrayestrela[1]}
                            />
                            <Image
                              style={estilos.ministar}
                              source={arrayestrela[2]}
                            />
                            <Image
                              style={estilos.ministar}
                              source={arrayestrela[3]}
                            />
                            <Image
                              style={estilos.ministar}
                              source={arrayestrela[4]}
                            />
                          </View>
                        </View>
                      </View>
                      <Image
                        source={require('../images/paginadetalhes/line.png')}
                        style={{alignSelf: 'center', resizeMode: 'contain'}}
                      />
                    </View>
                  ) : (
                    <View></View>
                  )}
                  {loading2 ? (
                    <View
                      style={{
                        marginTop: 100,
                        marginBottom: 1000,
                        alignItems: 'center',
                        justifyContent: 'center',
                      }}>
                      <ActivityIndicator size={50} color="#910046" />
                    </View>
                  ) : (
                    <View></View>
                  )}
                </>
              }
              ListEmptyComponent={
                <>
                  {loading ? (
                    <View
                      style={{
                        marginTop: 100,
                        marginBottom: 200,
                        alignItems: 'center',
                        justifyContent: 'center',
                      }}>
                      <ActivityIndicator size={50} color="#910046" />
                    </View>
                  ) : (
                    <View style={{marginHorizontal: 30, marginVertical: 50}}>
                      <View style={{alignItems: 'center'}}>
                        <Image
                          style={estilos.star}
                          source={require('../images/paginadetalhes/warning-purple.png')}
                        />
                        <Text
                          style={{
                            fontFamily: 'Poppins-Regular',
                            fontSize: 16,
                            color: '#000',
                            textAlign: 'center',
                            marginVertical: 10,
                          }}>
                          Este estabelecimento ainda n??o recebeu nenhuma
                          avalia????o.
                        </Text>
                        <Text
                          style={{
                            fontFamily: 'Poppins-Bold',
                            fontSize: 16,
                            color: '#000',
                            textAlign: 'center',
                          }}>
                          Seja o primeiro a Avaliar!
                        </Text>
                      </View>
                    </View>
                  )}
                </>
              }
              onEndReached={() => {
                setAdditem(additem + 3);
              }}
              onEndReachedThreshold={0.1}
              ListFooterComponent={
                <>
                  {loading && additem > 3 ? (
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
                      onPress={() => {
                        setMostrar(false), loadApi(), setLoading2(true);
                        setTimeout(() => {
                          setLoading2(false);
                        }, 2000);
                      }}>
                      <Image
                        style={{height: 25, width: 25}}
                        source={require('../images/configuracao/close.png')}
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
        </View>
      </Modal>
    </View>
  );
}

const estilos = StyleSheet.create({
  container: {},
  menuBar: {
    Flex: 1,
    marginTop: 18,
  },
  h1: {
    fontSize: 18,
    fontFamily: 'Poppins-SemiBold',
    color: '#000',
  },
  txt: {
    fontSize: 13,
    fontFamily: 'Poppins-Regular',
    color: '#414141',
    bottom: 8,
  },
  txtDistancia: {
    fontSize: 18,
    fontFamily: 'Roboto-Bold',
    color: '#910046',
    marginLeft: 15,
  },

  star: {
    height: 30,
    width: 30,
    marginRight: 5,
  },
  ministar: {
    height: 20,
    width: 20,
  },
  btn: {
    backgroundColor: 'rgba(146, 0 , 70, 0.28)',
    borderRadius: 5,
    borderColor: '#920046',
    borderWidth: 1,
    height: 45,
    width: 140,
  },
  txtBtn: {
    flex: 1,
    fontSize: 17,
    fontFamily: 'Poppins-SemiBold',
    textAlign: 'center',
    textAlignVertical: 'center',
    color: '#920046',
    paddingTop: 5,
    letterSpacing: 1,
  },
  input: {
    borderWidth: 1,
    width:
      Dimensions.get('window').width - Dimensions.get('window').width * 0.2,
    borderRadius: 10,
    height: 100,
    color: '#000',
    borderColor: '#920046',
    textAlignVertical: 'top',
    paddingHorizontal: 10,
  },
  containerModal: {
    alignSelf: 'center',
    width:
      Dimensions.get('window').width - Dimensions.get('window').width * 0.1,
    height: 230,
    padding: 20,
    borderRadius: 30,
    backgroundColor: '#fff',
    elevation: 5,
    top: '25%',
  },
  containerModal2: {
    alignSelf: 'center',
    alignItems: 'center',
    width:
      Dimensions.get('window').width - Dimensions.get('window').width * 0.05,
    height:
      Dimensions.get('window').height - Dimensions.get('window').height * 0.12,
    paddingTop: 15,
    borderTopLeftRadius: 30,
    borderTopRightRadius: 30,
    backgroundColor: '#fff',
    elevation: 5,
    top: '12%',
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
    textAlign: 'center',
    fontSize: 16,
    fontFamily: 'Poppins-Regular',
    marginTop: 10,
    color: '#000',
  },
});
