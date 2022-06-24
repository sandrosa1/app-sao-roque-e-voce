import React, {useState, useEffect, useRef} from 'react';
import {
  StyleSheet,
  SafeAreaView,
  Text,
  View,
  Image,
  ScrollView,
  FlatList,
  ActivityIndicator,
  Animated,
  TextInput,
  TouchableOpacity,
  Platform,
  PermissionsAndroid,
  Modal,
} from 'react-native';
import Header from '../../componentes/Header';
import MenuBar from '../../componentes/MenuBar';
import CardHome from '../../componentes/CardHome';
import AsyncStorage from '@react-native-async-storage/async-storage';
import Globais from '../../componentes/Globais';
import {useIsFocused} from '@react-navigation/native';
import axios from 'axios';
import Geolocation from '@react-native-community/geolocation';

export default function App() {
  const url = 'http://www.racsstudios.com/api/v1/home';
  const urlAll = 'http://www.racsstudios.com/api/v1/allapps';
  const [dados, setDados] = useState([]);
  const [dadosAll, setDadosAll] = useState(null);
  const [mostrar, setMostrar] = useState(true);
  const [reload, setReload] = useState(false);
  const [loading, setLoading] = useState(false);
  const [additem, setAdditem] = useState(5);
  const [filtro, setFiltro] = useState(dados);
  const [login, setLoagin] = useState(true);
  const [logado, setLogado] = useState(false);
  const [busca, setBusca] = useState('');
  const [mostrarx, setMostrarx] = useState(false);
  const [mostrarbusca, setMostrarbusca] = useState(false);
  const [mostrarLoading, setMostrarLoading] = useState(false);
  const isFocused = useIsFocused();
  const input = useRef();

  const [currentLatitude, setCurrentLatitude] = useState(null);
  const [currentLongitude, setCurrentLongitude] = useState(null);
  const [watchID, setWatchID] = useState(0);

  const callLocation = () => {
    if (Platform.OS == 'ios') {
      getLocation();
    } else {
      const requestLocationPermission = async () => {
        const granted = await PermissionsAndroid.request(
          PermissionsAndroid.PERMISSIONS.ACCESS_FINE_LOCATION,
          {
            title: 'Permissão de acesso a Localização',
            message:
              'Deseja permitir que o aplicativo acesse a sua localização?',
            buttonNeutral: 'Depois',
            buttonNegative: 'Cancelar',
            buttonPositive: 'Ok',
          },
        );
        if (granted == PermissionsAndroid.RESULTS.GRANTED) {
          getLocation();
        } else {
          Globais.dados = 0;
          setMostrarx(false);
        }
      };
      requestLocationPermission();
    }
  };

  const getLocation = () => {
    Geolocation.getCurrentPosition(
      position => {
        const currentLatitude = JSON.stringify(position.coords.latitude);
        const currentLongitude = JSON.stringify(position.coords.longitude);
        setCurrentLatitude(currentLatitude);
        setCurrentLongitude(currentLongitude);
      },
      error => {},
      {enableHighAccuracy: true, timeout: 20000, maximumAge: 1000},
    );
    const watchID = Geolocation.watchPosition(position => {
      const currentLatitude = JSON.stringify(position.coords.latitude);
      const currentLongitude = JSON.stringify(position.coords.longitude);
      setCurrentLatitude(currentLatitude);
      setCurrentLongitude(currentLongitude);
    });
    setWatchID(watchID);
  };

  useEffect(() => {
    if (isFocused) {
      callLocation();
    }
  }, [isFocused]);

  function getDistanceFromLatLonInKm(position1, position2) {
    'use strict';
    var deg2rad = function (deg) {
        return deg * (Math.PI / 180);
      },
      R = 6371,
      dLat = deg2rad(position2.lat - position1.lat),
      dLng = deg2rad(position2.lng - position1.lng),
      a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(deg2rad(position1.lat)) *
          Math.cos(deg2rad(position1.lat)) *
          Math.sin(dLng / 2) *
          Math.sin(dLng / 2),
      c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return (R * c * 1).toFixed(1);
  }

  function modificarFiltro() {
    if (dadosAll != null) {
      dadosAll.forEach(element => {
        element.distancia = getDistanceFromLatLonInKm(
          {lat: currentLatitude, lng: currentLongitude},
          {lat: element.latitude, lng: element.longitude},
        );
      });
      Globais.distancia = dadosAll;
      setReload(true);
    }
  }

  useEffect(() => {
    if (currentLatitude) {
      modificarFiltro();
      setMostrar(false);
    }
  }, [currentLatitude]);

  useEffect(() => {
    if (dadosAll) {
      modificarFiltro();
    }
  }, [dadosAll, reload]);

  if (reload == true) {
    modificarFiltro();
    setReload();
  }

  useEffect(() => {
    setBusca('');
    setMostrarx(false);
    setMostrarbusca(false);
    loadApi();
  }, [isFocused, additem]);

  async function loadApi() {
    if (loading) return;
    setLoading(true);
    const response = await axios.get(url);
    const responseAll = await axios.get(urlAll);
    setTimeout(() => {
      setDados(response.data.appsMostViewed);
      setDadosAll(responseAll.data.apps);
    }, 200);
    setTimeout(() => {
      setLoading(false);
    }, 350);
  }

  useEffect(() => {
    setFiltro(
      dados.filter((item, indice) => {
        if (
          item.segmento !== 'servicos'
          //  && indice < additem
        ) {
          return true;
        }
      }),
    );
  }, [dados]);

  const buscar = () => {
    if (busca == '') {
      setFiltro(
        dados.filter((item, indice) => {
          if (
            item.segmento !== 'servicos'
            //  && indice < additem
          ) {
            return true;
          }
        }),
      );
    } else {
      setMostrarbusca(true);
      setFiltro(
        dadosAll.filter(item => {
          if (
            (item.nomeFantasia.toLowerCase().indexOf(busca.toLowerCase()) >
              -1 ||
              item.chaves.toLowerCase().indexOf(busca.toLowerCase()) > -1) &&
            item.segmento != 'servicos'
          ) {
            console.log(item.segmento);
            return true;
          } else {
            return false;
          }
        }),
      );
    }
  };

  const limpaBusca = () => {
    setFiltro(
      dados.filter((item, indice) => {
        if (
          item.segmento !== 'servicos'
          //  && indice < additem
        ) {
          return true;
        }
      }),
    );
  };

  function verificarLogin() {
    if (Globais.dados?.usernome) {
      setLogado(true);
      setLoagin(false);
    } else {
      setLogado(false);
      setLoagin(true);
    }
  }

  useEffect(() => {
    const dadosdousuario = async () => {
      const json = await AsyncStorage.getItem('usuario');
      if (json) {
        Globais.dados = JSON.parse(json);
      }
    };
    verificarLogin();
    dadosdousuario();
    setTimeout(() => {
      setMostrar(false);
    }, 3000);
  }, [isFocused, loading]);

  const scrollY = new Animated.Value(0);
  const diffClamp = Animated.diffClamp(scrollY, 0, 140);
  const translate = diffClamp.interpolate({
    inputRange: [0, 140, 280],
    outputRange: [0, -140, -280],
  });

  return (
    <SafeAreaView style={estilos.container}>
      <Animated.View
        style={{
          position: 'absolute',
          zIndex: 9,
          backgroundColor: '#f3f3f3',
          top: 0,
          transform: [{translateY: translate}],
        }}>
        <Header nobr={true} login={login} logado={logado} goingback={false} />
        <View style={{flex: 1}}>
          <View
            style={{
              paddingHorizontal: 40,
              flexDirection: 'row',
              alignItems: 'center',
            }}>
            <View style={estilos.containerBusca}>
              <TextInput
                ref={input}
                onSubmitEditing={() => {
                  buscar();
                  input.current.blur();
                  if (busca) setMostrarx(true);
                  setMostrarLoading(false);
                  setTimeout(() => {
                    setMostrarLoading(true);
                  }, 1500);
                }}
                value={busca}
                onChangeText={value => {
                  setBusca(value);
                  setMostrarbusca(false);
                }}
                placeholder={'O que voce procura?'}
                placeholderTextColor={'#8E8E8E'}
                style={estilos.input}></TextInput>
            </View>
            <TouchableOpacity
              onPress={() => {
                buscar();
                input.current.blur();
                if (busca) setMostrarx(true);
                setMostrarLoading(false);
                setTimeout(() => {
                  setMostrarLoading(true);
                }, 1500);
              }}
              style={{
                position: 'absolute',
                alignSelf: 'center',
                right: 50,
                padding: 10,
              }}>
              <Image
                style={estilos.img}
                source={require('../../images/buscar.png')}
              />
            </TouchableOpacity>
            {mostrarx && (
              <TouchableOpacity
                onPress={() => {
                  setMostrarbusca(false);
                  limpaBusca();
                  setBusca('');
                  input.current.blur();
                  setMostrarx(false);
                }}
                style={{
                  position: 'absolute',
                  alignSelf: 'center',
                  left: 40,
                  padding: 10,
                }}>
                <Image
                  style={estilos.img2}                  
                  source={require('../../images/close.png')}
                />
              </TouchableOpacity>
            )}
          </View>
          <View style={estilos.menuBar}>
            <ScrollView
              horizontal={true}
              showsHorizontalScrollIndicator={false}>
              <MenuBar
                nome={'Turismo'}
                icon={require('../../images/menubar/pontos.png')}
                pesquisa={'Turismo'}
                busca={'turismo'}
              />
              <MenuBar
                nome={'Hospedagem'}
                icon={require('../../images/menubar/hotel.png')}
                pesquisa={'Hospedagem'}
                busca={'hospedagem'}
              />
              <MenuBar
                nome={'Gastronomia'}
                icon={require('../../images/menubar/gastronomia.png')}
                pesquisa={'Gastronomia'}
                busca={'gastronomia'}
              />
              <MenuBar
                nome={'Comércio'}
                icon={require('../../images/menubar/comercio.png')}
                pesquisa={'Comércio'}
                busca={'comercio'}
              />
              <MenuBar
                nome={'Eventos'}
                icon={require('../../images/menubar/evento.png')}
                pesquisa={'Eventos'}
                busca={'evento'}
              />
              <MenuBar
                nome={'Serviços'}
                icon={require('../../images/menubar/servico.png')}
                pesquisa={'Servicos'}
              />
              <MenuBar
                nome={'Sobre Nós'}
                icon={require('../../images/menubar/quemsomos.png')}
                pesquisa={'QuemSomos'}
              />
              <MenuBar
                nome={'Ajustes'}
                icon={require('../../images/menubar/config.png')}
                pesquisa={'Configuracao'}
              />
            </ScrollView>
            <Image
              source={require('../../images/line.png')}
              style={{alignSelf: 'center', resizeMode: 'contain'}}
            />
          </View>
        </View>
      </Animated.View>
      <View style={{flex: 1}}>
        <FlatList
          scrollEventThrottle={16}
          onScroll={Animated.event(
            [
              {
                nativeEvent: {
                  contentOffset: {y: scrollY},
                },
              },
            ],
            {useNativeDriver: false},
          )}
          showsVerticalScrollIndicator={false}
          data={filtro}
          keyExtractor={item => String(item.idApp)}
          renderItem={({item}) => <CardHome data={item} />}
          ListHeaderComponent={
            <>
              <View style={{marginHorizontal: 35}}>
                <View style={{height: 230}}></View>
                {/* <View>
                  <Text>voce esta aqui</Text>
                  <Text>Latitude: {currentLatitude}</Text>
                  <Text>Longitude: {currentLongitude}</Text>                 
                  <TouchableOpacity
                  onPress={()=>calcularDistancia()}
                  ><Text>Obter Localização</Text></TouchableOpacity>
                  <TouchableOpacity
                  onPress={()=>clearLocation()}
                  ><Text>Cancelar Monitoração</Text></TouchableOpacity>
                </View> */}
                {mostrarbusca ? (
                  <View>
                    <Text style={[estilos.h1, {fontSize: 22}]}>Busca</Text>
                    <View style={{flexDirection: 'row'}}>
                      <Text style={estilos.txt}>Resultado de busca para </Text>
                      <Text
                        style={[
                          estilos.txt,
                          {fontFamily: 'Poppins-Bold', color: '#000'},
                        ]}>
                        {busca?.toUpperCase()}:
                      </Text>
                    </View>
                  </View>
                ) : (
                  <View>
                    <Text style={estilos.h1}>Destaques</Text>
                    <Text style={estilos.txt}>Em dúvida para onde ir?</Text>
                    <Text style={estilos.txt}>
                      Conheça nossas dicas para a semana.
                    </Text>
                  </View>
                )}
              </View>
            </>
          }
          ListEmptyComponent={
            <>
              {!mostrarLoading ? (
                <View
                  style={{
                    marginTop: 150,
                    alignItems: 'center',
                    justifyContent: 'center',
                  }}>
                  <ActivityIndicator size={50} color="#910046" />
                </View>
              ) : (
                <View>
                  <View style={{marginHorizontal: 30, marginVertical: 50}}>
                    <View style={{alignItems: 'center'}}>
                      <Image
                        style={{width: 40, height: 40}}
                        source={require('../../images/paginadetalhes/warning-purple.png')}
                      />
                      <Text
                        style={{
                          fontFamily: 'Poppins-Regular',
                          fontSize: 16,
                          color: '#000',
                          textAlign: 'center',
                          marginTop: 5,
                        }}>
                        Não foi encontrado resultados para:
                      </Text>
                      <Text
                        style={{
                          fontFamily: 'Poppins-Bold',
                          fontSize: 16,
                          color: '#000',
                          textAlign: 'center',
                        }}>
                        " {busca} "
                      </Text>
                    </View>
                  </View>
                </View>
              )}
            </>
          }
          // onEndReached={() => {
          //   setAdditem(additem + 3);
          // }}
          // onEndReachedThreshold={0.10}
          ListFooterComponent={
            <>
              {loading && additem > 5 ? (
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
              <View
                style={{
                  flex: 1,
                  alignItems: 'center',
                  justifyContent: 'center',
                }}>
                <View
                  style={{
                    marginBottom: 75,
                    alignItems: 'center',
                    justifyContent: 'center',
                  }}>
                  <ActivityIndicator size={75} color="#910046" />
                </View>
              </View>
            </View>
          </View>
        </Modal>
      </View>
    </SafeAreaView>
  );
}

const estilos = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
  },
  menuBar: {
    Flex: 1,
    marginTop: 18,
  },
  h1: {
    marginTop: 15,
    fontSize: 24,
    fontFamily: 'Poppins-Regular',
    color: '#910046',
  },
  txt: {
    fontSize: 15,
    fontFamily: 'Poppins-Regular',
    color: '#414141',
  },
  input: {
    width: '75%',
    height: 48,
    fontSize: 14,
    top: 2,
    paddingLeft: 30,
    borderColor: '#E7E7E7',
    backgroundColor: '#E7E7E7',
    fontFamily: 'Poppins-Regular',
    borderRadius: 8,
    color: '#333',
  },
  containerBusca: {
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
  img2: {
    height: 15,
    width: 15,
    resizeMode: 'contain',
  },
});
