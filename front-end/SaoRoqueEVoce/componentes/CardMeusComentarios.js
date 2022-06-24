import React, {useState, useEffect} from 'react';
import {
  StyleSheet,
  Text,
  View,
  TouchableOpacity,
  Image,
  Dimensions,
  Modal,
  ActivityIndicator,
  TextInput,
} from 'react-native';
import Globais from './Globais';
import {useNavigation} from '@react-navigation/native';
import axios from 'axios';
import {Buffer} from 'buffer';

export default function App({data, props}) {
  const navigation = useNavigation();
  const [mostrarExcluir, setMostrarExcluir] = useState(false);
  const [mostrarEditar, setMostrarEditar] = useState(false);
  const [loadingResponse, setLoadingResponse] = useState(false);
  const [retorno, setRetorno] = useState(false);
  const [msg, setMsg] = useState(false);
  const [img, setImg] = useState();
  const [novoComentario, setNovocomentario] = useState(data.comentario);
  const [botao, setbotao] = useState(false);
  let title = data.estabelecimento;
  let datacompleta = data.data.substr(0, 10);
  let comentario = data.comentario;
  let estrelas = data.avaliacao;
  let arrayestrela = [];
  let i = 0;
  let nome = props?.nome;

  useEffect(() => {
    if (nome !== undefined) {
      setbotao(true);
    }
  }, []);

  let messtr = '';
  switch (datacompleta.substr(5, 2)) {
    case '01':
      messtr = 'Janeiro';
      break;
    case '02':
      messtr = 'Fevereiro';
      break;
    case '03':
      messtr = 'Março';
      break;
    case '04':
      messtr = 'Abril';
      break;
    case '05':
      messtr = 'Maio';
      break;
    case '06':
      messtr = 'Junho';
      break;
    case '07':
      messtr = 'Julho';
      break;
    case '08':
      messtr = 'Agosto';
      break;
    case '09':
      messtr = 'Setembro';
      break;
    case '10':
      messtr = 'Outubro';
      break;
    case '11':
      messtr = 'Novembro';
      break;
    case '12':
      messtr = 'Dezembro';
      break;
  }

  let dataconvertida =
    datacompleta.substr(8, 2) + ' ' + messtr + ' ' + datacompleta.substr(0, 4);

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

  const rota = () => {
    if (nome !== undefined) {
      setRetorno(false);
      setMostrarEditar(false);
      setMostrarExcluir(false);
      navigation.navigate('PaginaDetalhesComentario', {
        hookReload: 'hook' + new Date(),
        id: data.idApp,
      });
    } else {
      setRetorno(false);
      setMostrarEditar(false);
      setMostrarExcluir(false);
      navigation.navigate('Comentarios', {
        hookReload: 'hook' + new Date(),
      });
    }
  };

  const rota2 = () => {
    if (nome == undefined) {
      navigation.navigate('PaginaDetalhesComentario', {
        hookReload2: 'hook' + new Date(),
        id: data.idApp,
        meuscomentarios: 'meuscomentarios',
      });
    } else {
      navigation.navigate('Comentarios', {
        hookReload: 'hook' + new Date(),
      });
    }
  };

  function deletarComentario() {
    setRetorno(true);
    setLoadingResponse(true);
    let id = String(data.idComment);
    let username = Globais.dados.useremail;
    let password = Globais.dados.usertoken;
    let token = Buffer.from(`${username}:${password}`, 'utf8').toString(
      'base64',
    );
    let url = `http://www.racsstudios.com/api/v1/commentuser/${id}`;
    axios
      .delete(url, {headers: {Authorization: `Basic ${token}`}})
      .then(response => {
        if (response.data.success == true) {
          setImg(require('../images/configuracao/sucesso.png'));
          setMsg('Comentário excluído com sucesso!');
          setTimeout(() => {
            setLoadingResponse(false);
          }, 1500);
        }
      })
      .catch(error => {
        setImg(require('../images/configuracao/dangericon.png'));
        setMsg(
          'Houve um problema ao tentar excluir seu comentário!\nTente novamente.',
        );
        setTimeout(() => {
          setLoadingResponse(false);
        }, 1500);
      });
  }

  function editarComentario() {
    setRetorno(true);
    setLoadingResponse(true);
    let id = String(data.idComment);
    let username = Globais.dados.useremail;
    let password = Globais.dados.usertoken;
    let token = Buffer.from(`${username}:${password}`, 'utf8').toString(
      'base64',
    );
    let body = {
      idApp: data.idApp,
      comentario: novoComentario,
      avaliacao: data.avaliacao,
      custo: data.custo,
    };
    console.log(body);
    let url = `http://www.racsstudios.com/api/v1/comment/${id}`;
    axios
      .put(url, body, {headers: {Authorization: `Basic ${token}`}})
      .then(response => {
        setImg(require('../images/configuracao/sucesso.png'));
        setMsg('Comentário editado com sucesso!');
        setTimeout(() => {
          setLoadingResponse(false);
        }, 1500);
      })
      .catch(error => {
        setImg(require('../images/configuracao/error.png'));
        if (
          error.response.data.error ==
          'Existe palavras impróprias no coméntario'
        ) {
          setMsg('Não use vocabulário impróprio!');
          setTimeout(() => {
            setLoadingResponse(false);
          }, 1000);
        }
      });
  }

  return (
    <View>
      <TouchableOpacity
        style={{flex: 1}}
        onPress={() => {
          rota2();
        }}>
        <View style={estilos.cardBody}>
          <View
            style={{
              width:
                Dimensions.get('window').width -
                Dimensions.get('window').width * 0.15,
              padding: 10,
            }}>
            <View
              style={{
                flexDirection: 'row',
                justifyContent: 'space-between',
                alignItems: 'center',
              }}>
              <View>
                {nome ? (
                  <Text style={estilos.txtTitle}>{nome}</Text>
                ) : (
                  <Text style={estilos.txtTitle}>{title}</Text>
                )}
                <View style={{flexDirection: 'row'}}>
                  <Image style={estilos.star} source={arrayestrela[0]} />
                  <Image style={estilos.star} source={arrayestrela[1]} />
                  <Image style={estilos.star} source={arrayestrela[2]} />
                  <Image style={estilos.star} source={arrayestrela[3]} />
                  <Image style={estilos.star} source={arrayestrela[4]} />
                </View>
              </View>
              <View style={{position: 'absolute', right: 5, top: 28}}>
                <Text style={estilos.txtData}>{dataconvertida}</Text>
              </View>
            </View>
            <View
              style={{
                flex: 1,
                flexDirection: 'row',
                justifyContent: 'space-between',
              }}>
              <View style={{paddingVertical: 10, paddingRight: 15, flex: 1}}>
                <Text style={estilos.txtComantario}>{comentario}</Text>
              </View>
              <View
                style={{
                  height: '100%',
                  alignItems: 'flex-end',
                  justifyContent: 'flex-end',
                }}>
                <TouchableOpacity
                  style={{padding: 5, paddingVertical: 5}}
                  onPress={() => {
                    setMostrarEditar(true);
                  }}>
                  <Image
                    style={{width: 30, height: 30, resizeMode: 'contain'}}
                    source={require('../images/configuracao/editar.png')}
                  />
                </TouchableOpacity>
                <TouchableOpacity
                  style={{padding: 5, paddingVertical: 5}}
                  onPress={() => {
                    setMostrarExcluir(true);
                  }}>
                  <Image
                    style={{width: 30, height: 30, resizeMode: 'contain'}}
                    source={require('../images/configuracao/excluir.png')}
                  />
                </TouchableOpacity>
              </View>
            </View>
            {data.utilSim != 0 ? (
              <View
                style={{
                  flexDirection: 'row',
                  height: 40,
                  marginTop: 5,
                  paddingVertical: 5,
                  paddingTop: 10,
                }}>
                <Text style={estilos.txtData}>Seu comentário foi votado</Text>
                <View style={estilos.miniBtn}>
                  <Text style={estilos.txtMiniBtn}>{data.utilSim}</Text>
                </View>
                <Text style={estilos.txtData}>vezes como útil.</Text>
              </View>
            ) : (
              <View style={{height: 40}}></View>
            )}
          </View>
        </View>
      </TouchableOpacity>

      <View>
        <Modal visible={mostrarExcluir} transparent={true}>
          <View
            style={{
              flex: 1,
              alignItems: 'center',
              backgroundColor: 'rgba(0, 0 , 0, 0.8)',
              justifyContent: 'center',
            }}>
            <View style={[estilos.containerModal, {bottom: '5%'}]}>
              <View style={{alignItems: 'flex-end'}}>
                <TouchableOpacity
                  onPress={() => {
                    setMostrarExcluir(false);
                  }}>
                  <Image
                    style={{height: 25, width: 25}}
                    source={require('../images/configuracao/close.png')}
                  />
                </TouchableOpacity>
              </View>
              <View style={{alignItems: 'center'}}>
                <Image
                  source={require('../images/configuracao/dangericon.png')}
                />
                <Text
                  style={[estilos.txt, {paddingVertical: 10, fontSize: 14}]}>
                  Deseja excluir esse comentário?
                </Text>

                <View style={estilos.cardBody}>
                  <View
                    style={{
                      width:
                        Dimensions.get('window').width -
                        Dimensions.get('window').width * 0.225,
                      padding: 10,
                    }}>
                    <View
                      style={{
                        flexDirection: 'row',
                        justifyContent: 'space-between',
                        alignItems: 'flex-end',
                      }}>
                      <View
                        style={{flexDirection: 'row', alignItems: 'center'}}>
                        <View style={{marginRight: 5, width: 40, height: 40}}>
                          <Image
                            style={{
                              height: 40,
                              width: 40,
                              resizeMode: 'contain',
                            }}
                            source={require('../images/paginadetalhes/avatar.png')}
                          />
                        </View>
                        <View>
                          <Text style={estilos.txtTitle}>{title}</Text>
                          <View style={{flexDirection: 'row'}}>
                            <Image
                              style={estilos.star}
                              source={arrayestrela[0]}
                            />
                            <Image
                              style={estilos.star}
                              source={arrayestrela[1]}
                            />
                            <Image
                              style={estilos.star}
                              source={arrayestrela[2]}
                            />
                            <Image
                              style={estilos.star}
                              source={arrayestrela[3]}
                            />
                            <Image
                              style={estilos.star}
                              source={arrayestrela[4]}
                            />
                          </View>
                        </View>
                      </View>
                      <View
                        style={{
                          position: 'absolute',
                          right: 0,
                          alignSelf: 'flex-end',
                        }}>
                        <Text style={[estilos.txtData, {bottom: -6}]}>
                          {dataconvertida}
                        </Text>
                      </View>
                    </View>
                    <View style={{flexDirection: 'row', alignItems: 'center'}}>
                      <View style={{paddingVertical: 10}}>
                        <Text style={estilos.txtComantario}>{comentario}</Text>
                      </View>
                    </View>
                  </View>
                </View>
              </View>
              <View
                style={{alignItems: 'center', marginTop: 25, marginBottom: 20}}>
                <View style={{flexDirection: 'row', padding: 0}}>
                  <TouchableOpacity
                    style={estilos.btnBg}
                    onPress={() => {
                      setMostrarExcluir(false);
                    }}>
                    <Text style={[estilos.txtModal, {color: '#707070'}]}>
                      Não
                    </Text>
                  </TouchableOpacity>
                  <TouchableOpacity
                    style={[estilos.btnBg, {backgroundColor: '#920046'}]}
                    onPress={() => {
                      deletarComentario();
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
        <Modal visible={mostrarEditar} transparent={true}>
          <View
            style={{
              flex: 1,
              alignItems: 'center',
              justifyContent: 'center',
              backgroundColor: 'rgba(0, 0 , 0, 0.8)',
            }}>
            <View style={[estilos.containerModal, {bottom: '5%'}]}>
              <View style={{alignItems: 'flex-end'}}>
                <TouchableOpacity
                  onPress={() => {
                    setMostrarEditar(false);
                  }}>
                  <Image
                    style={{height: 25, width: 25}}
                    source={require('../images/configuracao/close.png')}
                  />
                </TouchableOpacity>
              </View>
              <View style={{alignItems: 'center'}}>
                <View style={{flexDirection: 'row', alignItems: 'center'}}>
                  <Image
                    style={{width: 25, height: 25}}
                    source={require('../images/configuracao/warningicon.png')}
                  />
                  <Text
                    style={[
                      estilos.txt,
                      {
                        paddingVertical: 10,
                        fontSize: 14,
                        paddingLeft: 5,
                        top: 3,
                      },
                    ]}>
                    Deseja Editar esse comentário?
                  </Text>
                </View>

                <View style={estilos.cardBody}>
                  <View
                    style={{
                      width:
                        Dimensions.get('window').width -
                        Dimensions.get('window').width * 0.225,
                      padding: 10,
                    }}>
                    <View
                      style={{
                        flexDirection: 'row',
                        justifyContent: 'space-between',
                        alignItems: 'flex-end',
                      }}>
                      <View
                        style={{flexDirection: 'row', alignItems: 'center'}}>
                        <View style={{marginRight: 5, width: 40, height: 40}}>
                          <Image
                            style={{
                              height: 40,
                              width: 40,
                              resizeMode: 'contain',
                            }}
                            source={require('../images/paginadetalhes/avatar.png')}
                          />
                        </View>
                        <View>
                          <Text style={estilos.txtTitle}>{title}</Text>
                          <View style={{flexDirection: 'row'}}>
                            <Image
                              style={estilos.star}
                              source={arrayestrela[0]}
                            />
                            <Image
                              style={estilos.star}
                              source={arrayestrela[1]}
                            />
                            <Image
                              style={estilos.star}
                              source={arrayestrela[2]}
                            />
                            <Image
                              style={estilos.star}
                              source={arrayestrela[3]}
                            />
                            <Image
                              style={estilos.star}
                              source={arrayestrela[4]}
                            />
                          </View>
                        </View>
                      </View>
                      <View
                        style={{
                          position: 'absolute',
                          right: 0,
                          alignSelf: 'flex-end',
                        }}>
                        <Text style={[estilos.txtData, {bottom: -6}]}>
                          {dataconvertida}
                        </Text>
                      </View>
                    </View>
                    <View style={{alignItems: 'center'}}>
                      <View style={{paddingVertical: 10}}>
                        <TextInput
                          multiline={true}
                          value={novoComentario}
                          onChangeText={setNovocomentario}
                          style={estilos.input}
                          placeholder={comentario}
                          placeholderTextColor={'#414141'}></TextInput>
                      </View>
                    </View>
                  </View>
                </View>
              </View>
              <View
                style={{alignItems: 'center', marginTop: 15, marginBottom: 10}}>
                <View style={{flexDirection: 'row', padding: 0}}>
                  <TouchableOpacity
                    style={estilos.btnBg}
                    onPress={() => {
                      setMostrarEditar(false);
                    }}>
                    <Text style={[estilos.txtModal, {color: '#707070'}]}>
                      Não
                    </Text>
                  </TouchableOpacity>
                  <TouchableOpacity
                    style={[estilos.btnBg, {backgroundColor: '#920046'}]}
                    onPress={() => {
                      editarComentario();
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
                    rota();
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
  txt: {
    fontSize: 10,
    fontFamily: 'Poppins-SemiBold',
    color: '#414141',
  },
  star: {
    width: 20,
    height: 20,
  },
  containerModal: {
    width:
      Dimensions.get('window').width - Dimensions.get('window').width * 0.1,
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
  btnBg: {
    width: 100,
    height: 45,
    backgroundColor: '#CCC',
    borderRadius: 34,
    alignItems: 'center',
    justifyContent: 'center',
    marginHorizontal: 15,
  },
  txtModal: {
    fontSize: 17,
    fontFamily: 'Poppins-Regular',
    color: '#000',
  },
  cardBody: {
    backgroundColor: '#E1E1E1',
    alignItems: 'center',
    marginVertical: 20,
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
  input: {
    width:
      Dimensions.get('window').width - Dimensions.get('window').width * 0.3,
    padding: 10,
    marginTop: 10,
    borderWidth: 1,
    borderRadius: 10,
    height: 80,
    color: '#000',
    borderColor: '#920046',
    textAlignVertical: 'top',
    paddingHorizontal: 10,
    backgroundColor: '#FCFCFC',
  },
  miniBtn: {
    backgroundColor: 'rgba(146, 0 , 70, 0.20)',
    borderRadius: 5,
    borderColor: '#920046',
    borderWidth: 1,
    marginHorizontal: 5,
    height: 20,
  },
  txtMiniBtn: {
    paddingHorizontal: 5,
    fontSize: 12,
    textAlign: 'center',
    textAlignVertical: 'center',
    color: '#920046',
    fontFamily: 'Roboto-Bold',
  },
});
